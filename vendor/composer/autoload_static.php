<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5200a96903bb0acdbd36f8309445a51a
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Alura\\Mvc\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Alura\\Mvc\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5200a96903bb0acdbd36f8309445a51a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5200a96903bb0acdbd36f8309445a51a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5200a96903bb0acdbd36f8309445a51a::$classMap;

        }, null, ClassLoader::class);
    }
}
