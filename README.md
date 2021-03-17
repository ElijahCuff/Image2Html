# Image 2 HTML 
## Email Image Blocking Bypass POC
### 2021 First of a kind.
After many days testing different methods, i have finally created a method to insert images into Gmail using this little gem.
     
> This PHP Script converts both PNG & JPG images into email acceptable html.     
> Q. How ?    
> A. The concept was simple,    
>  div elements have the ability to set the background colour,     
>  the most important part about this is that the background colour can be an RGB reference - this is perfect for what we need    
>  lining up div elements into a line of pixel representatives using 1px width and 1px height (1px = One Pixel)    
>  we can create a new line for each horizontal pixel in the image and then fill that line with 1px by 1px divs using RGB colours to match the pixels.    
>  the colours are recognised using 4 of PHP's functions, the first two - are to transform an image into a colour map resource.    
> `imagecreatefromjpeg($imgPath)` & the PNG alternative `imagecreatefrompng($imgPath)`   
>  then we use this colour map to identify the XY position colours array `imagecolorat($resource, $x, $y)` this function will return an array of colour amounts    
>  also including transparency that could be matched with the CSS opposite equivalent `opacity`.    
>  This example uses NO transparency but focuses only on RGB references.    
>  The usual Array response from imagecolourat consists of 4 parameters, RED - GREEN - BLUE - TRANSPARENCY  for every single pixel in the image.    
>      
>  The problem is that this is extremely time consuming for a small PHP server, each and every pixel is identified and replicated in pure HTML and CSS styling.  
>  The resulting Page very large if the provided image is even small, but the bypass is successful.   
>  I would recommend nothing larger than 20x20 pixels to be immediately delivered to the email address - Anything Over that seems to need the user to press "Download Full Email" to load the complete image.    
>  It is almost as useful as pressing "Allow Images".    
  
  
### Simple API Added


```  
<?php

// Woke World HTML Image Bypass POC in PHP
// This script will convert the image provided by the path on server into an email ready html colour image. - tested using Gmail 15/3/2021


// Set The Information
$to = 'Woke@gmail.com';
$from = 'mailer@smtpmail.ml';
$nameFrom = 'Woke World';
$replyTo = 'exampe@smtpmail.ml';
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
```
```
