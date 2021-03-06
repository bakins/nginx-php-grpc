<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit74dd92fc4ba40130d8e05052821c66f2
{
    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'Grpc\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Grpc\\' => 
        array (
            0 => __DIR__ . '/..' . '/grpc/grpc/src/lib',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit74dd92fc4ba40130d8e05052821c66f2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit74dd92fc4ba40130d8e05052821c66f2::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
