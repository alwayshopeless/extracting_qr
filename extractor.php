<?php
include "vendor/autoload.php";
include "inc/funcs.php";
include "inc/cleanerfunc.php";
define("QR_SIZE", 86);
define("START_OFFSET_X", 16);
define("START_OFFSET_Y", 13);
use GifFrameExtractor\GifFrameExtractor;
$gifFilePath = 'code.gif';
if (GifFrameExtractor::isAnimatedGif($gifFilePath)) { // check this is an animated GIF
    $gfe = new GifFrameExtractor();
    $gfe->extract($gifFilePath);
}
$frames = $gfe->getFrameImages();
$frames = array_reverse($frames);
$i = 0;
$noisedQr = [];
foreach ($frames as $frame) {
    $currentImg = $frame;
    $currentImg = normalizeColor($currentImg);
    if (($i * 3) <= (333 - QR_SIZE - START_OFFSET_X)) {
        $tempImg = imagecreate(QR_SIZE, QR_SIZE);
        imagecopy($tempImg, $currentImg, 0, 0, START_OFFSET_X + ($i * 3), START_OFFSET_Y, QR_SIZE, QR_SIZE);
        imagedestroy($currentImg);
        $noisedQr[] = $tempImg;
    } else {
        break;
    }
    $i++;
}
header('Content-Type: image/gif');
for ($i = 1; $i <= 10; $i++) {
    $final = resourceByMap(imageIntersection($noisedQr, $i / 10), QR_SIZE, QR_SIZE);
    imagegif($final, "./".($i*10)."%.gif");
}