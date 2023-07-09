<?php

function processFile($sourceFilePath)
{
    $newFilePath = str_replace("jpg", "png", str_replace("/uploads", "/uploads/processed", str_replace("./", "/", $sourceFilePath)));

    $img = new Imagick($_SERVER['DOCUMENT_ROOT'] . $sourceFilePath);

    // Need to be in a format that supports transparency
    $img->setimageformat('png');

    /* The target pixel to paint */
    $x = 1;
    $y = 1;

    /* Get the color we are painting */
    $targetColor = $img->getImagePixelColor($x, $y);

    $alpha = 0.0;
    $fuzz = 0.9;

    $img->transparentPaintImage($targetColor, $alpha, $fuzz, false);

    // Not required, but helps tidy up left over pixels
    $img->despeckleimage();

    $img->writeImage($_SERVER['DOCUMENT_ROOT'] . $newFilePath);

    return [
        "success" => true,
        "error" => null,
        "newImagePath" => $newFilePath
    ];
}
