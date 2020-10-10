<?php

class MultipleUpload
{
	protected $title, $name, $logo, $errors, $extensions;

	public function __construct($config = array())
	{
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		$this->errors = array();

		$this->title = 'Upload files';
		$this->name = 'plugin';
		$this->logo = '';

		$this->extensions_img  = '|jpg|jpeg|gif|png|tif';
		$this->extensions_mov  = '|mov|avi|swf|asf|wmv|mpg|mpeg|mp4|flv';
		$this->extensions_docs = '|txt|doc|docx|pdf|zip';
		$this->extensions_audio = '|wav|mp3';
		$this->type = 'img';

		$this->original = '/upload';
		$this->thumbs = '/th';
		$this->loRes = '/LO';
		$this->folder = '';
		$this->minImageSize = 1200;


		if (isset($config['title'])) $this->title = $config['title'];
		if (isset($config['name'])) $this->name = $config['name'];
		if (isset($config['logo'])) $this->logo = $config['logo'];
	}

	protected function error($method, $msg, $return = false)
	{
		$this->errors[] = array(
			'method' => $method,
			'msg' => $msg
		);

		return $return;
	}

	/**
	 * Check if the current logged-in user is an adminstrator
	 * @return  boolean
	 */
	public function is_admin()
	{
		$mi = getMemberInfo();
		if (!($mi['admin'] && ((is_string($mi['group']) && $mi['group'] == 'Admins') || (is_array($mi['group']) && array_search("Admins", $mi['group']))))) {
			return false;
		}
		return true;
	}

	/**
	 * get max. file size from php.ini configuration
	 */
	public function parse_size($size)
	{
		$unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
		$size = preg_replace('/[^0-9\.]/', '', $size); 		// Remove the non-numeric characters from the size.
		if ($unit) {
			// Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
			return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
		} else {
			return round($size);
		}
	}

	/**
	 * Loads a given view, passing the given data to it
	 * @param $view the path of a php file to be loaded
	 * @return the output of the parsed view as a string
	 */
	public function view($view)
	{
		if (!is_file($view)) {
			return $this->error('view', "'{$view}' is not a file");
		}
		ob_start();
		@include($view);
		$out = ob_get_contents();
		ob_end_clean();

		return $out;
	}

	public function process_ajax_upload()
	{
		$resources_dir = dirname(__FILE__);
		$base_dir = realpath("{$resources_dir}/../..");
		include_once("$base_dir/lib.php");

		$maxFileSize = ($this->parse_size(ini_get('post_max_size')) < $this->parse_size(ini_get('upload_max_filesize')) ? ini_get('post_max_size') : ini_get('upload_max_filesize'));
		$extensiones_docs = $this->extensions_docs;
		$extensiones_mov = $this->extensions_mov;
		$extensiones_img = $this->extensions_img;
		$extensiones_audio = $this->extensions_audio;
		$this->size = 'false';
		$extensiones = $extensiones_img . $extensiones_docs . $extensiones_mov . $extensiones_audio;

		$mi = getMemberInfo();
		$aproveUpload = FALSE;

		if ($mi['admin']) {
			$aproveUpload = true;
		}

		try {

			//if file exceeded the filesize, no file will be sent
			if (!isset($_FILES['uploadedFile'])) {
				//throw new RuntimeException("No file sent you must upload a file not greater than $maxFileSize");
			}

			$file = pathinfo($_FILES['uploadedFile']['name']);
			$ext = strtolower($file['extension']); // get the extension of the file	
			$filename = $file['filename'];

			// Undefined | Multiple Files | $_FILES Corruption Attack
			// If this request falls under any of them, treat it invalid.

			// Check $_FILES['uploadedFile']['error'] value.
			switch ($_FILES['uploadedFile']['error']) {
				case UPLOAD_ERR_OK:
					break;
				case UPLOAD_ERR_NO_FILE:
					throw new RuntimeException('No file sent.');
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					throw new RuntimeException('You must upload a file not greater than $maxFileSize"');
				default:
					throw new RuntimeException('Unknown errors.');
			}

			//Check extention
			if (strpos($extensiones_docs, $ext)) {
				//it is a doc
				$this->type = 'doc';
			}

			if (strpos($extensiones_mov, $ext)) {
				//it is movie
				$this->type = 'mov';
			}
			if (strpos($extensiones_audio, $ext)) {
				//it is movie
				$this->type = 'audio';
			}

			$extensiones = explode('|', $extensiones);
			if (!in_array(strtolower($ext), $extensiones)) {
				throw new RuntimeException('You must upload a (' . implode("|", $extensiones) . ') file');
			}

			// $_FILES['uploadedFile']['name'] validation
			if (!preg_match('/^[A-Za-z0-9-_]/', $_FILES['uploadedFile']['name'])) {
				throw new RuntimeException('File was not uploaded. The file can only contain "A-Z", "a-z", "0-9", "_" and "-".');
			}
			
			
			
		} catch (RuntimeException $e) {
			$a = dirname(__FILE__);
			header('Content-Type: application/json');
			header($_SERVER['SERVER_PROTOCOL'] . 'error; Content-Type: application/json', true, 400);
			echo json_encode(array(
				"error" => $e->getMessage() . $a
			));
		}


			//check existing projects' names 

			$folder_base = $base_dir . $this->folder;
			$original = $folder_base . $this->original;

			$currentFiles = scandir($original);

			natsort($currentFiles);
			$currentFiles = array_reverse($currentFiles);

			$renameFlag = false;

			foreach ($currentFiles as $projName) {
				if (preg_match('/^' . $filename . '(-[0-9]+)?\.' . $ext . '$/i', $projName)) {

					$matches = array();
					if (!strcmp($_FILES['uploadedFile']['name'], $projName)) {
						$newName = $filename . "-" . "1" . ".$ext";
						$new_name = $filename . "-" . "1";
						$renameFlag = true;
					} else {
						//increment number at the end of the name ( sorted desc, first one is the largest number)
						preg_match('/(-[0-9]+)\.' . $ext . '$/i', $projName, $matches);
						$number = preg_replace("/[^0-9]/", '', $matches[0]);
						$newName = $filename . "-" . (((int)$number) + 1) . ".$ext";
						$new_name = $filename . "-" . (((int)$number) + 1);
						$renameFlag = true;
						break;
					}
				} else {
					//found name without number at the previous loop, and name with number not found at this loop
					if ($renameFlag) {
						break;
					}
				}
			}

			if ($renameFlag) {
				$filename = $new_name;
			}

			if (!move_uploaded_file($_FILES['uploadedFile']['tmp_name'], sprintf($original . '/%s', ($renameFlag ? $newName : $_FILES['uploadedFile']['name'])))) {
				throw new RuntimeException('Failed to move uploaded file.');
			} else {
				$exit = false;
				if ($this->type === 'img' || strtolower($ext) === 'pdf' || $this->type === 'mov') {
					//add thumbsnail
					include '_resampledIMG.php';
					$exit = make_thumb($renameFlag ? $newName : $file['basename'], $filename, $ext, $this, $ret);
					//agregar a la tabla de files
				}
				//file uploaded successfully	
				header('Content-Type: application/json; charset=utf-8');						
				echo json_encode(array(
					"response-type" => "success",
					"defaultImage"  => false,
					"isRenamed"     => $renameFlag,
					"fileName"      => $renameFlag ? $newName : $_FILES['uploadedFile']['name'],
					"extension"     => $ext,
					"name"          => $filename,
					"type"          => $this->type,
					"hd_image"      => $exit,
					"folder"        => $original,
					"folder_base"   => $this->folder,
					"size"          => $this->size,
					"userUpload"    => $mi['username'],
					"aproveUpload"  => $aproveUpload,
				));
			}
			return;
	}

}
