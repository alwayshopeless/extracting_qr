<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9e7e5734f7b6a8f874eeec9943494b15
{
    public static $prefixesPsr0 = array (
        'G' => 
        array (
            'GifFrameExtractor' => 
            array (
                0 => __DIR__ . '/..' . '/sybio/gif-frame-extractor/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit9e7e5734f7b6a8f874eeec9943494b15::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}