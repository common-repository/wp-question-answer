<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit54a9842ffe4b8e1eb820ecffbc5cecc7
{
    public static $prefixLengthsPsr4 = array (
        'Q' => 
        array (
            'QuestionAnswer\\' => 15,
        ),
        'P' => 
        array (
            'Premmerce\\SDK\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'QuestionAnswer\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Premmerce\\SDK\\' => 
        array (
            0 => __DIR__ . '/..' . '/premmerce/wordpress-sdk/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit54a9842ffe4b8e1eb820ecffbc5cecc7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit54a9842ffe4b8e1eb820ecffbc5cecc7::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
