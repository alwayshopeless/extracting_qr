<?php
include "vendor/autoload.php";
include "inc/funcs.php";
include "inc/cleanerfunc.php";

use GifFrameExtractor\GifFrameExtractor;
$startTime = microtime(true);
$gifFilePath = 'code.gif';
if (GifFrameExtractor::isAnimatedGif($gifFilePath)) { // check this is an animated GIF
    $gfe = new GifFrameExtractor();
    $gfe->extract($gifFilePath);
}
$frames = $gfe->getFrameImages();
$i = 0;
$noisedQr = [];
for($i=0; $i<count($frames); $i++) {
    $frame = array_pop($frames);
    normalizeColor($frame);
    removeVoids($frame, 0, 1);
    removeOffsets($frame);
    createDirs("source");
    imagegif($frame, "source/$i.gif");
//    break;
}
$closeTime = microtime(true)-$startTime;
echo $closeTime;
