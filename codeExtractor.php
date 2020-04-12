<?php
include "vendor/autoload.php";
include "inc/funcs.php";
include "inc/cleanerfunc.php";
define("QR_SIZE", 58);
define("START_OFFSET_X", 10);
define("START_OFFSET_Y", 0);
function getFile($filename, $extention, $start, $end){
    for($i = $start; $i<$end; $i++){
        yield $i => imagecreatefromgif("source/$filename$i.$extention");
    }
}
$noisedQr = [];
foreach (getFile("", "gif", 0, 76) as $num => $frame) {
    $currentImg = $frame;
    if(!isset($imgWidth)){
        $imgWidth = imagesx($currentImg);
    }
    $tempImg = imagecreate(QR_SIZE, QR_SIZE);
    imagecopy($tempImg, $currentImg, 0, 0, START_OFFSET_X + ($num * 2), START_OFFSET_Y, QR_SIZE, QR_SIZE);
    imagedestroy($currentImg);
    $noisedQr[] = $tempImg;
}
header('Content-Type: image/gif');
for ($i = 1; $i <= 10; $i++) {
    $final = resourceByMap(imageIntersection($noisedQr, $i / 10), QR_SIZE, QR_SIZE);
    createDirs("qrs");
    imagegif($final, "qrs/".($i*10)."%.gif");
    createDirs("qrs_noised");
    imagegif($noisedQr[$i], "qrs_noised/".($i*10)."%.gif");
    #раскоментриуй строку выше, если хочешь поулчить в папке qrs_noised зашумленные коды
}