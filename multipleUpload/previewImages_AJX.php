<?php

if (!isset($_POST['cmd'])){
    return;
}
include '../lib.php';
if (isset($_POST['source'])){
    $source = makeSafe($_POST['source']);
    $ret = pdfPages($source);
    echo json_encode(array(
            'ret' => $ret,
            'tag' => $_POST['id']
        ));
    return;
}

function pdfPages($source){
    $cant = 1;
    if (file_exists($source)){
            $pages = new Imagick();
            $pages->pingimage($source);
            $cant = $pages->getNumberImages();
            $pages   ->clear();
            $pages   ->destroy();
        }
    return $cant;
}