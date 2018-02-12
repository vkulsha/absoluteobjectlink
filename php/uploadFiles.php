<?php
require('conn.php');
header('Content-Type: text/html; charset=utf-8');
header('Access-Control-Allow-Origin: *');

if (isset($_GET['u'])) {
	$u = isset($_GET['u']) ? $_GET['u'] : 0;
} else if (isset($_POST['u'])) {
	$u = isset($_POST['u']) ? $_POST['u'] : 0;
};
$objectlink->u = $u;

$uploaddir = $_POST['uploadPath'];
$uploadid = $_POST['uploadId'];
$uploadcids = json_decode($_POST['uploadCids']);

$typePhoto = ["image/jpeg", "image/png"];
$files = [];
$oids = [];
$ret;

if (!file_exists($uploaddir)) {mkdir($uploaddir);};

try{
	for($i=0; $i<count($_FILES['userfile']['name']); $i++){
		$uploadfile = $uploaddir . basename( $_FILES['userfile']['name'][$i] );
		$tempfile = $_FILES['userfile']['tmp_name'][$i];
		move_uploaded_file($tempfile, mb_convert_encoding($uploadfile,  "cp1251", "UTF-8"));
		$filetype = $_FILES['userfile']['type'][$i];
		
		if (in_array($filetype, $typePhoto)){
			$files[]["photo"] = $uploadfile;
		} else {
			$files[]["other"] = $uploadfile;
		};
		
	}

	$cidFile = $objectlink->gO(["Файлы", true]);
	$cidPhoto = $objectlink->gO(["Фото", true]);
	if (!$uploadcids || !count($uploadcids)){
		$uploadcids = Array($cidFile);
	}
	
	for($i=0; $i<count($files); $i++){
		$filename = array_key_exists("photo", $files[$i]) ? $files[$i]["photo"] : $files[$i]["other"];

		if ( $objectlink->getPolicy(["cL", $cidFile]) || $objectlink->getPolicy(["cL", $cidPhoto]) ) {        
			$oid = $objectlink->cO([$filename, $uploadid], true);
			
			if ($oid) {
					if ($cidFile) {	$objectlink->cL([$oid, $cidFile], true); }
					if ($cidPhoto && array_key_exists("photo", $files[$i])) { $objectlink->cL([$oid, $cidPhoto], true);	}
				//}
			}
			$oids[] = $oid;
		} else { 
			try { 
				unlink(basename(mb_convert_encoding($filename, "cp1251", "UTF-8"))); 
				return; 
			} catch(Exception $e) { 
				echo json_encode(false, JSON_UNESCAPED_UNICODE); 
			} 
		};
	}

	$ret = $oids;
} catch (Exception $e) {
	$ret = null;
}
echo json_encode($ret, JSON_UNESCAPED_UNICODE);

?>