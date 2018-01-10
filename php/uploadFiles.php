<?php
require('conn.php');
if (isset($_GET['u'])) {
	$u = isset($_GET['u']) ? $_GET['u'] : 0;
} else if (isset($_POST['u'])) {
	$u = isset($_POST['u']) ? $_POST['u'] : 0;
};
$objectlink->u = $u;

header('Content-Type: text/html; charset=utf-8');
$uploaddir = $_POST['uploadPath'];
$uploadid = $_POST['uploadId'];

mkdir($uploaddir);
$typePhoto = ["image/jpeg", "image/png"];
$files = [];
$oids = [];

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

	$cidFile = $objectlink->gO(["Файлы"]);
	$cidPhoto = $objectlink->gO(["Фото"]);

	for($i=0; $i<count($files); $i++){
		$filename = array_key_exists("photo", $files[$i]) ? $files[$i]["photo"] : $files[$i]["other"];

		$oid = $objectlink->cO([$filename, $uploadid], true);
		
		if ($oid) {
			if ($cidFile) {	$objectlink->cL([$oid, $cidFile], true); }
			if ($cidPhoto && array_key_exists("photo", $files[$i])) { $objectlink->cL([$oid, $cidPhoto], true);	}
		}
		$oids[] = $oid;
	}

	//header('Location: ' . $_SERVER['HTTP_REFERER']);
	//header("location:javascript://history.go(-1)");
	//echo "<script>window.close();</script>";
	//if (count($oids))
	echo json_encode($oids);

} catch (Exception $e) {
	echo json_encode(false);
}

?>