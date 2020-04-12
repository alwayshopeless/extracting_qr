<?php
function getArraysIntersect($array){
    $result = [];
    foreach ($array as $keyArr => $item){
        foreach ($item as $itemKey => $itemVal){
            $result[$itemKey] = $result[$itemKey]??0;
            $result[$itemKey] += $itemVal;
        }
    }
    return $result;
}
/**
 * @param $image
 * @return array
 * Return two-tone pixel map of image
 */
function getPixelMap($image){
    $firstColor = imagecolorsforindex($image, imagecolorat($image, 0, 0));
    for ($x=0; $x < imagesx($image); $x++) {
        for ($y=0; $y < imagesy($image); $y++) {
            $color = imagecolorsforindex($image, imagecolorat($image, $x, $y));
            if($color==$firstColor){
                $current = 1;
            }
            else{
                $current = 0;
            }
            $map[]= $current;
        }
    }
    return $map;
}

/**
 * @param mixed ...$images
 * @return mixed
 * Finds the intersection of images end return pixel map.
 */
function imageIntersection($images, $coeff){
    $coords = [];
    $imageCount = count($images);
    foreach ($images as $img) {
        $coords[] = getPixelMap($img);
    }
    $occurrence = getArraysIntersect($coords);
    array_walk($occurrence, function(&$value, &$key) use ($coeff, $imageCount){
        if(($value / $imageCount) >= $coeff){
            $value = 1;
        } else {
            $value = 0;
        }
    });
    return $occurrence;
}
function resourceByMap($pixelMap, $width, $height){
    $image = imagecreate($width, $height);
    $white = imagecolorallocate($image, 255, 255, 255);
    $black = imagecolorallocate($image, 0, 0, 0);
    $i = 0;
    for ($x=0; $x < $width; $x++) {
        for ($y=0; $y < $height; $y++) {
            if($pixelMap[$i]){
                $current = $white;
            }
            else{
                $current = $black;
            }
            imagesetpixel($image, $x, $y, $current);
            $i++;
        }
    }
    return $image;
}