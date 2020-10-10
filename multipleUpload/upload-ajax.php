<?php

include(dirname(__FILE__) . '/MultipleUpload.php');
	 $folder = '';
    if (isset($_GET['f'])) $folder =$_GET['f'];
	$plugin = new MultipleUpload();
        $plugin ->folder = $folder;
	$plugin->process_ajax_upload();