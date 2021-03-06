<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfacf9eacf3e04d8dfdb102fa45c80302
{
    public static $files = array (
        '33197a0023ced5fbf8f861d1c4ca048d' => __DIR__ . '/..' . '/topthink/think-orm/src/config.php',
    );

    public static $prefixLengthsPsr4 = array (
        'w' => 
        array (
            'wangshouwei\\session\\' => 20,
        ),
        't' => 
        array (
            'think\\' => 6,
        ),
        'i' => 
        array (
            'init\\' => 5,
        ),
        'e' => 
        array (
            'epii\\ui\\upload\\' => 15,
            'epii\\ui\\login\\' => 14,
            'epii\\tools\\classes\\' => 19,
            'epii\\template\\' => 14,
            'epii\\server\\' => 12,
            'epii\\orm\\' => 9,
            'epii\\cache\\' => 11,
            'epii\\app\\' => 9,
            'epii\\api\\result\\' => 16,
            'epii\\admin\\ui\\' => 14,
            'epii\\admin\\center\\' => 18,
        ),
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'wangshouwei\\session\\' => 
        array (
            0 => __DIR__ . '/..' . '/wangshouwei/session/src',
        ),
        'think\\' => 
        array (
            0 => __DIR__ . '/..' . '/epii/think-orm/src/think',
            1 => __DIR__ . '/..' . '/topthink/think-orm/src',
        ),
        'init\\' => 
        array (
            0 => __DIR__ . '/../..' . '/init',
        ),
        'epii\\ui\\upload\\' => 
        array (
            0 => __DIR__ . '/..' . '/epii/admin-ui-upload/src',
        ),
        'epii\\ui\\login\\' => 
        array (
            0 => __DIR__ . '/..' . '/epii/admin-ui-login/src',
        ),
        'epii\\tools\\classes\\' => 
        array (
            0 => __DIR__ . '/..' . '/epii/get-all-classes-and-methods-for-namespaces/src',
        ),
        'epii\\template\\' => 
        array (
            0 => __DIR__ . '/..' . '/epii/template-engine/src',
        ),
        'epii\\server\\' => 
        array (
            0 => __DIR__ . '/..' . '/epii/tiny-app/src',
        ),
        'epii\\orm\\' => 
        array (
            0 => __DIR__ . '/..' . '/epii/think-orm/src',
        ),
        'epii\\cache\\' => 
        array (
            0 => __DIR__ . '/..' . '/epii/cache/src',
        ),
        'epii\\app\\' => 
        array (
            0 => __DIR__ . '/..' . '/epii/tiny-app-plus/src',
        ),
        'epii\\api\\result\\' => 
        array (
            0 => __DIR__ . '/..' . '/epii/api-result/src',
        ),
        'epii\\admin\\ui\\' => 
        array (
            0 => __DIR__ . '/..' . '/epii/admin-ui/src',
        ),
        'epii\\admin\\center\\' => 
        array (
            0 => __DIR__ . '/..' . '/epii/admin-center/src',
        ),
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfacf9eacf3e04d8dfdb102fa45c80302::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfacf9eacf3e04d8dfdb102fa45c80302::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
