<?php
// Woke World HTML Image POC in PHP
// This script will convert the image provided by the url GET parameters into an email ready html colour image.

if (!hasParam("url"))
{
 $url = "https://raw.githubusercontent.com/WokeWorld/DivPixel/main/test.png";
}
else
{
$url = urlDecode($_REQUEST["url"]);
}
if (!hasParam("scale"))
{
 $scale = 1;
}
else
{
 $scale = $_REQUEST["scale"];
}
if (!hasParam("download"))
{
 $download = false;
}
else
{
$download = ($_REQUEST["download"] == "true");
}


$fileName = get_file_name(basename($url));
$image = get_file($url);

$type = strtolower(trim(get_file_extension($url)));
$file = $fileName."_image2html_".$type;
file_put_contents($file, $image);






if ($type == "png" || $type == "jpg")
{
  if($download) {
      $html = image2html($file,$type,$scale);
      file_put_contents($file, $html);
      serveDL($file, true);
    }
   else {
      $data = image2html($file,$type,$scale);
      unlink($file);
      echo $data;
  }
}
else
{
echo 'Invalid image format provided.';
}

function get_file_extension($file_name) {
	return substr(strrchr($file_name,'.'),1);
}
function get_file_name($file_name) {
	return substr($file_name, 0, strpos($file_name,"."));
}

function image2html($imgPath , $type, $scale)
{
if ($type == "png")
{
$resource = imagecreatefrompng($imgPath);
}
else
{
$resource = imagecreatefromjpeg($imgPath);
}
if ($scale == 0){$scale = 1;}


$width = imagesx($resource);
$height = imagesy($resource);

$html_start_1 = '<html>
<head>
<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">

</head>
<body>
<div align="center" width="device-width" max-width="device-width" onclick="this.style=\'height:0px\';" >

<div style="max-height:'.$height*$scale.'px; max-width:'.$width*$scale.'px; min-height:'.$height*$scale.'px; min-width:'.$width*$scale.'px; height:'.$height*$scale.'px; width:'.$width*$scale.'px; border:-0.3px; margin:-0.3px;">';

$blocks = '';

$html_end = '</div><div style="clear: both;"><div></div></div></body></html>';


for($y = 0; $y < $height; $y++) {
   for($x = 0; $x < $width; $x++) {
        $color = imagecolorat($resource, $x, $y);
        $color_rgb = imagecolorsforindex($resource, $color);
        $red = $color_rgb["red"];
        $green = $color_rgb["green"];
        $blue = $color_rgb["blue"];
        $alpha = $color_rgb["alpha"];
        $blocks .= "\n".'<div class="item"  style="background-color: rgb('.$red.','.$green.','.$blue.'); border:-0.3px; margin:-0.3px; float:left; width:'.$scale.'px; height:'.$scale.'px;"></div>';
         if ($x == $width-1)
         { 
           $blocks .= '<div style="clear: both;"></div>';
         }
    } 
}

$build = $html_start_1.$blocks.$html_end;
return $build;
}

function get_file($url)
{
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);
$data = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
return $data.$err;
}

function serveDL($file, $deleteAfter = true)
{
    $fileName = basename($file);
    $filePath = $file;
    if(!empty($fileName) && file_exists($filePath)){
        // Define headers
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$fileName");
        header("Content-Type: text/html");
        header("Content-Transfer-Encoding: binary");
        
        // Read the file
        readfile($filePath);
       if($deleteAfter)
        {
           unlink($file);
        }
        exit;
    }else{
        echo 'The file does not exist.';
    }
}

function hasParam($param) 
{
   return array_key_exists($param, $_REQUEST);
}

?>
