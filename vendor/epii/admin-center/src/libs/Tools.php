<?php

namespace epii\admin\center\libs;

use Closure;
use epii\server\App;

/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/1/9
 * Time: 9:20 AM
 */
class Tools
{
    public static function get_current_url()
    {
        return self::get_web_http_domain() . $_SERVER['REQUEST_URI'];
    }

    public static function get_web_root()
    {

        return self::get_web_http_domain().(isset($_SERVER["REQUEST_URI"])?parse_url("http://www.ba.ldi/".$_SERVER["REQUEST_URI"])["path"]:"");
    }

    public static function get_web_http_domain()
    {
        $current_url = 'http://';
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $current_url = 'https://';
        }
        $http =explode(":",$_SERVER['HTTP_HOST']);
        $_SERVER['HTTP_HOST'] = $http[0];

        if (!isset($_SERVER['SERVER_PORT']))
        {
            $_SERVER['SERVER_PORT'] = isset($http[1])?$http[1]:"80";
        }
        if ($_SERVER['SERVER_PORT'] != '80') {
            $current_url .= $_SERVER['HTTP_HOST'] . ':' . $_SERVER['SERVER_PORT'];
        } else {
            $current_url .= $_SERVER['HTTP_HOST'];
        }
        return $current_url . (substr($_SERVER["SCRIPT_NAME"], 0, strrpos($_SERVER["SCRIPT_NAME"], "/")));
    }


    public static function getEnableNameSpacePre()
    {
        $name_pre = Tools::getObjectAttr(App::getInstance(), "name_space_pre", App::class);
        $app_need = true;
        foreach ($name_pre as $value) {
            if (stripos($value, "app\\") === 0) {
                $app_need = false;
                break;
            }
        }
        if ($app_need) {
            $name_pre[] = "app";
        }
        return $name_pre;
    }

    public static function getObjectAttr($object, $name, $newscop = null)
    {
        $tmp = Closure::bind(function () use ($name) {
           return $this->{$name};
        }, $object, $newscop ? $newscop : get_class($object));


        return $tmp();
    }


    private static $vendor_dir = null;

    public static function getVendorDir()
    {

        if (self::$vendor_dir !== null) {
            return self::$vendor_dir;
        }

        $files = get_required_files();
        if ($files) {
            foreach ($files as $file) {

                if (substr($file, $pos = -strlen($find = "composer".DIRECTORY_SEPARATOR."ClassLoader.php")) == $find) {
                    return self::$vendor_dir = substr($file, 0, $pos - 1);
                }
            }
        }
        return self::$vendor_dir = "";
    }

}