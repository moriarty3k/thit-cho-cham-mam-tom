<?php

//require_once('server.php');
session_start();
create_image();

function create_image()
{
    // Generating Random Code
    //$chars = '123456';
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $captcha = substr(str_shuffle($chars), 0, 6);

    $_SESSION['captcha'] = $captcha;

    $width = 140;
    $height = 50;
    
    $image = ImageCreate($width,$height);

    // Colors
    $white = imagecolorallocate($image, 255, 255, 255);
    $black = imagecolorallocate($image, 0, 0, 0);
    $green = imagecolorallocate($image, 0, 255, 0);
    $brown = imagecolorallocate($image, 139, 69, 19);
    $orange = imagecolorallocate($image, 255, 69, 0);
    $grey = imagecolorallocate($image, 204, 204, 204);

    // Making Background
    imagefill($image, 0, 0, $white);

    // Carving Text into the image
    $font= "./css/RubikSprayPaint-Regular.ttf";
    imagettftext($image, 20, 10, 10, 40, $black, $font, $captcha);

    // Informing Browser there is a jpeg image file is coming
    header("Content-Type: image/png");

    //Converting Image into JPEG
    imagepng($image);
    // Clearing Cache
    imagedestroy($image);
}
?>