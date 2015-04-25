<?php

include '../src/ImageRecognize.class.php';

$imgpath = 'forz.jpg';
$imgRecognize = new ImageRecognize($imgpath);
$data = $imgRecognize->recognize();
$result = '';
$buffer = '';
for($i=2; $i < $imgRecognize->imgsize[1]; ++$i)
{
	$result = '';
    for($j=0; $j < $imgRecognize->imgsize[0]; ++$j)
    {
	    $result .= $data[$i][$j];
    }
    $buffer .= $result;
    echo $result.'<br/>';
}
/*$imgRecognize->imgsize = getimagesize($imgpath);
$res = imagecreatefromjpeg($imgpath);



imagedestroy($res);

*/
?>

<textarea rows="12" cols="70"><?php echo str_replace('<br/>', '', $buffer)?></textarea>