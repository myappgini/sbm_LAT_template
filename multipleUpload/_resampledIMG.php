<?php
if (isset($_POST['cmd']) && $_POST['cmd'] === 'newPDF'){
    include('multipleUpload/loader.php');
    
    $folder = new MultipleUpload();
    $folder -> folder=$_POST['$folder'];
    make_thumb($_POST['$fileName'], $_POST['$source'], $_POST['$ext'] ,$folder,$_POST['$page']);
    echo 'true';
    
}
function make_thumb($source, $fileName, $ext ,&$folder,&$ret){
        $exit = false;
        $currDir = dirname(__FILE__);
        $base_dir = realpath("{$currDir}/../..");
        header('Content-type: images');
        $page = 0;
        
        if ($folder->type === 'mov'){
            //make_thumb_mov($source, $fileName, $ext ,$folder, $ret);
            return;
        }
        
        if ($ret) $page = intval($ret)-1;
        
            $fo = $base_dir. $folder->folder;
            $source = $fo.$folder->original.'/'.$source;
            $target = $fo.$folder->thumbs.'/'.$fileName . '_th.jpg';
            
            
                    if (extension_loaded('imagick')){
                        if(strtolower($ext) === 'pdf'){
                            $im   = new \Imagick($source.'[' . $page . ']');
                        }else{
                            $im   = new \Imagick($source);
                        }
                        $color= new \ImagickPixel();
                        $d = $im->getImageGeometry();

                        if(strtolower($ext) === 'pdf'){
                            $quantum = $im->getQuantum();
                        }

                        $im   	->setimageformat("jpg");
                        $im   	->setresolution(72, 72);
                        $im   	->thumbnailimage(300, 0); // width and height
                        $im   	->writeimage($target);
                        $im   	->clear();
                        $im   	->destroy();
                        $w = $d['width'];
                        $h = $d['height']; 
                        if(strtolower($ext) !== 'pdf'){
                            $folder ->size = $w . "x" . $h;
                        }
                        if ($w > 1200 && strtolower($ext) !== 'pdf'){
                            //create friendlyimage
                            $target = $fo.$folder->loRes.'/'.$fileName . '_LO.jpg';
                            $im   = new Imagick($source); // 0-first page, 1-second page
                            $color= new ImagickPixel();
                            
                            //$im   ->setImageColorspace(255); // prevent image colors from inverting
                            $im   ->setimageformat("jpeg");
                            $im   ->setresolution(1200, 1200);
                            $im   ->borderImage($color, 1, 1);
                            $im   ->thumbnailimage(1200, 0); // width and height
                            $im   ->writeimage($target);
                            $im   ->clear();
                            $im   ->destroy();
                            $exit = true;
                        }
                        return $exit;
                }else{
//                    echo 'imagick not installed';
                    throw new RuntimeException('i can\'t make a thumb imagenMagick not installed ');
                }
}

function make_thumb_mov($source, $fileName, $ext ,$folder,&$ret){
    // $currDir = dirname(__FILE__);
    // $base_dir = realpath("{$currDir}/..");
    // $fo = $base_dir. $folder->folder;
    // $source = $fo.$folder->original.'/'.$source;

    // require $base_dir.'/vendor/autoload.php';
    // $ffmpeg = FFMpeg\FFMpeg::create();
    // $ffprobe = FFMpeg\FFProbe::create();


    // $duration = $ffprobe
    //     ->format($source) // extracts file informations
    //     ->get('duration');             // returns the duration property

    // $video = $ffmpeg->open($source);
    // $video
    //     ->filters()
    //     ->resize(new FFMpeg\Coordinate\Dimension(320, 240))
    //     ->synchronize();


    // $th = 5;
    // $intervalo = $duration/$th;

    // $target = $fo.$folder->thumbs.'/'. $fileName . '_th.jpg';

    // for ($x = 1; $x <= 4; $x++) {
    //     $video
    //         ->frame(FFMpeg\Coordinate\TimeCode::fromSeconds($intervalo * $x))
    //         ->save($target);
    //     $target = $fo.$folder->thumbs.'/'. $fileName .'('. $x . ')_th.jpg';
    // } 

    return;
}