<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit00a84bc389504d96ef3441d1684e801b
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Spatie\\SchemaOrg\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Spatie\\SchemaOrg\\' => 
        array (
            0 => __DIR__ . '/..' . '/spatie/schema-org/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit00a84bc389504d96ef3441d1684e801b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit00a84bc389504d96ef3441d1684e801b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit00a84bc389504d96ef3441d1684e801b::$classMap;

        }, null, ClassLoader::class);
    }
}
