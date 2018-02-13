<?php
require_once 'modules/PHPWord.php';
require_once 'Image.php';

if (isset($_GET['data'])) {
	$data = $_GET['data'];
} else if (isset($_POST['data'])) {
	$data = $_POST['data'];
};
$data = $data ? json_decode($data) : [];

$caption = $data->caption;
$data = $data->data;

$word = new PHPWord();
$word->setDefaultFontName('Veranda');
$word->setDefaultFontSize(11);

$section = $word->createSection();

$section->addTextBreak(11);
$section->addImage("../images/logo.png", array('width'=>128, 'height'=>128, 'align'=>'center') );
$section->addText("УПРАВЛЕНИЕ ЭКСПЛУАТАЦИИ ИМУЩЕСТВА", array('size'=>18, 'bold'=>true, 'align'=>'center'));
$section->addText("ФОТООТЧЕТ ПО ОБЪЕКТУ:", array('size'=>14, 'bold'=>true, 'align'=>'center'));
$section->addText($caption, array('size'=>12, 'bold'=>true, 'align'=>'center'));
$section->addPageBreak();

$images = $data[0]->images;
$caption = $data[0]->caption;
for ($i=0; $i < count($images); $i++ ){
	$fn = $images[$i];
	$n = split("/",$fn);
	if ($n[0] != "..") $n[0] = "../".$n[0];
	$fn = join("/",$n);
	$fn = mb_convert_encoding($fn, "cp1251", "UTF-8");
	$image = new Image($fn);
	
	$fn = "tmp/file$i.jpg";
	$image->resize(640,380,'height')->save($fn);
	
	if (($i+1) % 2) {
		$section->addText($caption);
		$section->addImage($fn, array('align'=>'center') );
		$section->addTextBreak(2);
	} else {
		$section->addImage($fn, array('align'=>'center') );
		$section->addPageBreak();
	}
	
}

$objWriter = PHPWord_IOFactory::createWriter($word, 'Word2007');
$filename = 'tmp/Image.docx';
$objWriter->save($filename);

$ctype = "application/msword";
header("Pragma: public"); 
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
header("Content-Type: $ctype");
header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($filename)); 
readfile("$filename");
//unlink("$filename");
return true;

?>