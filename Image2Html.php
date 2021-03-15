<?php
// Woke World HTML Image Bypass POC in PHP
// This script will convert the image provided by the path on server into an email ready html colour image.


// Set The Information
$to = 'Woke@gmail.com';
$from = 'mailer@smtpmail.ml';
$nameFrom = 'Woke World';
$replyTo = 'mailer@smtpmail.ml';
$nameReply = 'Woke World';
$subject = 'BubbleTech';


// Setup Extra Data for Email
$message = image2html("test3.png","png", 2);
$headers  = "MIME-Version: 1.0
Content-type: text/html; charset=UTF-8
From: ".$nameFrom.' <'.$from.'>
Reply-To: '.$nameReply.' <'.$replyTo.'> 
X-Mailer: PHP/' . phpversion();

// Send Email Data
if (mail($to, $subject, $message, $headers))
{
echo "Sent Message\nTo :".$to."\n\n".$message;
}
else
{
echo ("Failure with Sending\n".$message."\n\n"."To : ".$to);
}


// Custom Jpeg or Png to HTML Elements function
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
<h2>Woke World</h2>
<div><p>Email Image Bypassing using HTML POC<br><a href="https://github.com/WokeWorld/Image2Html-Email-Image-Blocking-Bypass"></a></p></div>

<div style="max-height:'.$height*$scale.'px; max-width:'.$width*$scale.'px; min-height:'.$height*$scale.'px; min-width:'.$width*$scale.'px; height:'.$height*$scale.'px; width:'.$width*$scale.'px; border:-0.3px; margin:-0.3px;">';

$blocks = '';

$html_end = '</div><div style="clear: both;"><div>BOTTOM</div></div></body></html>';


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


?>
