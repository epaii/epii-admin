<?php

namespace epii\server;


/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/1/9
 * Time: 9:20 AM
 */
class Tools
{




    public static function mkdir($dir, $qx = 0777)
    {
        if (!is_dir($dir)) {
            $old = umask(0);
            mkdir($dir, $qx, true);
            umask($old);
        }


    }

    public static function get_current_url()
    {
        if (!isset($_SERVER['REQUEST_URI'])) return "";
        return self::get_web_http_domain() . $_SERVER['REQUEST_URI'];
    }

    public static function get_web_root()
    {
        if (!isset($_SERVER['REQUEST_URI'])) return "";

        $tmp = parse_url("http://www.ba.ldi/" . $_SERVER["REQUEST_URI"])["path"];

        if (strripos($tmp, "/") != (strlen($tmp) - 1)) {
            $tmp = pathinfo($tmp, PATHINFO_DIRNAME);
        }
        $uri = implode("/", array_filter(explode("/", $tmp)));

        return self::get_web_http_domain() . $uri . "/";
    }

    public static function get_web_http_domain()
    {
        if (!isset($_SERVER['HTTP_HOST'])) return "";
        $current_url = 'http://';
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $current_url = 'https://';
        }
        $http = explode(":", $_SERVER['HTTP_HOST']);
        $_SERVER['HTTP_HOST'] = $http[0];

        if (!isset($_SERVER['SERVER_PORT'])) {
            $_SERVER['SERVER_PORT'] = isset($http[1]) ? $http[1] : "80";
        }
        if ($_SERVER['SERVER_PORT'] != '80') {
            $current_url .= $_SERVER['HTTP_HOST'] . ':' . $_SERVER['SERVER_PORT'];
        } else {
            $current_url .= $_SERVER['HTTP_HOST'];
        }


        return $current_url;// . (substr($_SERVER["SCRIPT_NAME"], 0, strrpos($_SERVER["SCRIPT_NAME"], "/")));
    }


    public static function getRootFileDirectory()
    {

        return pathinfo($_SERVER["SCRIPT_FILENAME"], PATHINFO_DIRNAME);
    }

    public static function getRuntimeDirectory()
    {
        return self::getVendorDir() . "/../runtime";
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

                if (substr($file, $pos = -strlen($find = "composer" . DIRECTORY_SEPARATOR . "ClassLoader.php")) == $find) {
                    return self::$vendor_dir = substr($file, 0, $pos - 1);
                }
            }
        }
        return self::$vendor_dir = "";
    }

}