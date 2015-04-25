<?php

include '../src/ImageRecognize.class.php';

$imgpath = 'w.jpg';
$imgRecognize = new ImageRecognize($imgpath);
$imgRecognize->imgsize = getimagesize($imgpath);
$res = imagecreatefromjpeg($imgpath);

$arr = $imgRecognize->imgbinary($res);
for($i=2; $i < $imgRecognize->imgsize[1]; ++$i)
{
    for($j=0; $j < $imgRecognize->imgsize[0]; ++$j)
    {
	    echo $arr[$i][$j];
    }
    echo '<br />';
}

imagedestroy($res);

