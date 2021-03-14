<?php
// Woke World HTML Image Bypass on GitHub
$to = 'elijahcuff92@gmail.com';
$subject = 'Subject';
$message = image2html("test.png","png", 5);
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
$headers .= 'From: SMTP Mail <mailbot@smtpmail.ml>' . "\r\n" .
    'Reply-To: SMTP Mail <mailbot@smtpmail.ml>' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $message, $headers);
echo $message;

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
<body>
<h2>Welcome</h2>
<div><p>Security Test by Woke World.</p></div><br>
<div style="max-height:'.$height*$scale.'px; max-width:'.$width*$scale.'px; min-height:'.$height*$scale.'px; min-width:'.$width*$scale.'px; border: 4px solid black; position: relative; height:'.$height*$scale.'px; width:'.$width*$scale.'px; ">';

$blocks = '';

$html_end = '</div><div>BOTTOM</div></div></body></html>';


for($y = 0; $y < $height; $y++) {
   for($x = 0; $x < $width; $x++) {
        $color = imagecolorat($resource, $x, $y);
        $color_rgb = imagecolorsforindex($resource, $color);
        $red = $color_rgb["red"];
        $green = $color_rgb["green"];
        $blue = $color_rgb["blue"];
        $alpha = $color_rgb["alpha"];
        $blocks .= "\n".'<div id="pixel_y'.$y.'_x'.$x.'" style="background-color: rgb('.$red.','.$green.','.$blue.');  border:5px; float:left; min-width:'.$scale.'px; min-height:'.$scale.'px;  max-width:'.$scale.'px; max-height:'.$scale.'px;"></div>';
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