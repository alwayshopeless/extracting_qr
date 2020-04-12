<?php
include "vendor/autoload.php";
include "inc/funcs.php";
include "inc/cleanerfunc.php";

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
    normalizeColor($frame);
//    removeVoids($frame, 0, 1);
    imagegif($frame, "source/$i.gif");
    $i++;
    break;
}