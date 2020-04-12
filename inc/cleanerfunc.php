<?php
function reduceImage(&$img, $x, $y){
        $width = imagesx($img)-$x;
        $height = imagesy($img)-$y;
    $img = imagecrop($img, [
        "x" => 0,
        "y" => 0,
        "width" => $width,
        "height" => $height,
    ]);
}
/**
 * @param $targetImg resource
 * @param $sourceImg resource
 * @param $sx start x coo
 * @param $sy start y coo
 * @param $w width
 * @param $h height
 */
function delSectionLine(&$targetImg, &$sourceImg, $sx, $sy, $thickness, $mode = "v"){
    switch ($mode) {
    	case "h":
            $width = imagesx($sourceImg);
            $height = imagesy($sourceImg)-($sy + $thickness);
            $tx = 0;
            $ty = $sy;
            $sy += $thickness;
            $sx = 0;
            reduceImage($targetImg, 0, $thickness);
    		break;
        case "v":
            $width = imagesx($sourceImg)-($sx + $thickness);
            $height = imagesy($sourceImg);
            $tx = $sx;
            $ty = 0;
            $sx += $thickness;
            $sy = 0;
            reduceImage($targetImg, $thickness, 0);
            break;
    	default:
    		break;
    }
    imagecopy($targetImg, $sourceImg, $tx, $ty, $sx, $sy, $width, $height);
}
function removeVoids(&$resource, $offset, $thickness){
    for($i=$offset; $i<=(imagesx($resource)-$thickness); $i+=2){
        delSectionLine($resource, $resource, $i, 0, $thickness, "v");
    }
    for($i=$offset; $i<=(imagesy($resource)-$thickness); $i+=2){
        delSectionLine($resource, $resource, 0, $i, $thickness, "h");
    }
}
function removeOffsets(&$resource, $mode = "v"){
    $width = imagesx($resource);
    $height = imagesy($resource);
    switch ($mode) {
        case "h":
            break;
        case "v":
            $offsetOverFirst = 0;
            for($y = 0; $y<$height; $y++){
                $fistInLine = imagecolorat($resource, 0, $y);
                for($x = 0; $x<$width; $x++){
                    if($fistInLine != imagecolorat($resource, $x, $y)){
                        $offsetOverFirst = $y;
                        break 2;
                    }
                }
            }
            $offsetOverSecond = 0;
            for($y = $height-1; $y>0; $y--){
                $fistInLine = imagecolorat($resource, 0, $y);
                for($x = $width-1; $x>0; $x--){
                    if($fistInLine != imagecolorat($resource, $x, $y)){
                        $offsetOverSecond = $height-$y;
                        break 2;
                    }
                }
            }
            printf("ТА ЗА ШО?? \n%d %d %d %d \n", $width, $height, $offsetOverFirst, $offsetOverSecond);
            $height - $offsetOverFirst - $offsetOverSecond;
            $resource = imagecrop($resource, [
                'x' => 0,
                'y' => $offsetOverFirst,
                'width' => $width,
                'height' => $height,
            ]);
            break;
        default:
            break;
    }
}