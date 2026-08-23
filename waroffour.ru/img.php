<?php
if (isset($_REQUEST['type'])) $type = $_REQUEST['type'];
if (!isset($type))$type='png';
if ($type!='jpeg'&&$type!='gif')$type='png';

$code = (eregi("^[0-9]+$",$_GET['code']))? $_GET['code']:"--";
$code_confirm = hexdec(md5(md5($code.$_SERVER['REMOTE_ADDR'])));
$code_confirm = substr($code_confirm,3,6);

if ($type=='png')header("Content-type: image/png");
if ($type=='jpeg')header("Content-type: image/jpeg");
if ($type=='gif')header("Content-type: image/gif");
/*
$im = imagecreate(140,16);
$color_white = imagecolorallocate($im,255,255,255);
$color = imagecolorallocate($im,211,211,211);
//$color_gray = imagecolorallocate($im,159,159,159);
$color_gray = imagecolorallocate($im,100,100,100);

imagestring($im,5, rand(40,44),rand(0,4), $code_confirm, $color);
imagestring($im,5, rand(38,42),rand(0,4), $code_confirm, $color_gray);
imageline($im,0,0,140,0,$color);
imageline($im,0,6,140,6,$color);
//imageline($im,0,9,140,9,$color);
imageline($im,0,15,140,15,$color);
*/

// create a 100*30 image
$im = imagecreate(100, 30);

// white background and blue text
$bg = imagecolorallocate($im, 255, 255, 255);
$textcolor = imagecolorallocate($im, rand(0,255), rand(0,255), rand(0,255));
$color = imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
$color1 = imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
$color2 = imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
imageline($im,0,rand(0,30),rand(0,140),0,$color);
imageline($im,0,rand(0,30),rand(0,140),6,$color1);

// write the string at the top left
imagestring($im, rand(4,5), rand(0,7),  rand(0,7), $code_confirm, $textcolor);
imageline($im,0,rand(0,30),rand(0,140),6,$color2);

if ($type=='png')imagepng($im);
if ($type=='jpeg')imagejpeg($im);
if ($type=='gif')imagegif($im);
imagedestroy($im);

?>