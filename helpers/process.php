<?php

function processFile($sourceFilePath, $transformationType, $textLineOne = '', $textLineTwo = '')
{
    $newFilePath = str_replace("jpg", "png", str_replace("/uploads", "/uploads/processed", str_replace("./", "/", $sourceFilePath)));

    $img = new Imagick($_SERVER['DOCUMENT_ROOT'] . $sourceFilePath);

    // Need to be in a format that supports transparency
    $img->setimageformat('png');

    $img->resizeImage(400, 0, Imagick::FILTER_LANCZOS, 1);

    switch ($transformationType) {
            // case 'removeBg':
            //     /* The target pixel to paint */
            //     $x = 1;
            //     $y = 1;

            //     /* Get the color we are painting */
            //     $targetColor = $img->getImagePixelColor($x, $y);

            //     $alpha = 0.0;
            //     $fuzz = 0.9;

            //     $img->transparentPaintImage($targetColor, $alpha, $fuzz, false);

            //     // Not required, but helps tidy up left over pixels
            //     $img->despeckleimage();

            //     break;

        case 'removeBg':
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

            break;
        case 'memeGen':
            $draw = new ImagickDraw();

            /* Black text */
            $draw->setFillColor('red');

            /* Font properties */
            // $draw->setFont('Bookman-DemiItalic');
            $draw->setFontSize(20);

            /* Create text */
            $img->annotateImage($draw, 10, 30, 0, $textLineOne);
            $img->annotateImage($draw, 10, 55, 0, $textLineTwo);

            break;
        default:
            break;
    }

    $img->writeImage($_SERVER['DOCUMENT_ROOT'] . $newFilePath);

    return [
        "success" => true,
        "error" => null,
        "newImagePath" => $newFilePath
    ];
}
