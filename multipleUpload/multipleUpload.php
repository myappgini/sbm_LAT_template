<?php
$currDir = dirname(__FILE__);
$base_dir = realpath("{$currDir}/../..");
include($currDir.'/MultipleUpload.php');
if (!isset($_REQUEST['f'])) die("You can't call this file directly.");
$ext = new MultipleUpload();
if (!function_exists('makeSafe')) {
        include("$base_dir/lib.php");
}
$f = new Request('f');

?>
<div class="dz-container">
        <div id="response" class="row"></div>
        <div id="my-awesome-dropzone" class="dropzone">
                <i class="glyphicon glyphicon-upload"></i>
        </div>
</div>
<script>
        var ext = "." + '<?php echo $ext->extensions_img . "|" . $ext->extensions_mov . "|" . $ext->extensions_docs . "|" . $upload->extensions_audio; 
                                ?>';
        ext = ext.replace(/\|/g, ",.");
        var images = [];
        $j("div#my-awesome-dropzone").dropzone({
                paramName: "uploadedFile", // The name that will be used to transfer the file
                maxFilesize: 200048,
                url: "LAT/multipleUpload/upload-ajax.php?f=" + "<?php echo $f->raw; ?>",
                acceptedFiles: ext,
                uploadMultiple: false,
                accept: function(file, done) {
                        done();
                },
                init: function() {
                        this.on("success", function(file, response) {
                                $j(".dropzone").css("border", "3px dotted blue");
                                if (response["response-type"] === "success") {
                                        var successDiv = $j("<div />", {
                                                class: "alert alert-success",
                                                style: "display: none; padding-top: 6px; padding-bottom: 6px;"
                                        });
                                        var successMsg = "Send OK." + (response.isRenamed ? "<br>File name exist, new name: " + response.fileName + "." : "");

                                        images.push(response); //adding new image to array
                                        successDiv.html(successMsg);
                                        $j("#response").html(successDiv);
                                        setTimeout(deleteFile, 2500, file, this);
                                }
                        });
                        this.on("queuecomplete", function(file, reponse) {
                                jsonImages(images);
                                images = [];
                        });
                        this.on("error", function(file, response) {
                                if ($j.type(response) === "string") {
                                        response = "Você precisa enviar um arquivo válido: " + response; //dropzone sends it's own error messages in string
                                } else {
                                        response = response['error'];
                                }
                                $j("#response").html("<div class='alert alert-danger'>" + response + "</div>");
                                $j(".dropzone").css("border", "3px dotted red");

                                setTimeout(deleteFile, 4000, file, this);
                        });
                }
        })

        function deleteFile(file, elm) {
                elm.removeFile(file);
        }
</script>