<?php
namespace epii\template;

use epii\template\engine\EpiiViewEngine;
use epii\template\engine\PhpViewEngine;
use epii\template\i\IEpiiViewEngine;


/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/12/25
 * Time: 1:02 PM
 */
class View
{

    /*
     * @IEpiiViewEngine
     */
    private static $engine = null;
    private static $config = [];

    private static $replace_string = [];

    private static $comon_data = [];


    public static function setEngine(Array $config, string $engine = null)
    {
        self::$engine = $engine == null ? EpiiViewEngine::class : $engine;
        if (!class_exists(self::$engine)) {
            echo "tmplate engine not exists!";
            exit();
        }


        self::$config = $config;
        $keys = (self::$engine)::require_config_keys();
        foreach ($keys as $name) {
            if (!isset($config[$name])) {
                echo "tmplate config need require $name!\n";
                exit();
            }
        }

    }


    public static function addStringRule($string_find, $string_replace)
    {

        self::$replace_string[0][] = $string_find;
        self::$replace_string[1][] = $string_replace;

    }

    public static function addPregRule($preg_find, $replace_string)
    {

        self::$replace_string[2][] = $preg_find;
        self::$replace_string[3][] = $replace_string;

    }

    public static function addPregRuleCallBack($preg_find, callable $replace)
    {
        self::$replace_string[4][$preg_find] = $replace;

    }

    public static function addCommonData(Array $data)
    {
        if ($data) {
            self::$comon_data = array_merge(self::$comon_data, $data);
        }
    }


    public static function display(string $file, Array $args = null, IEpiiViewEngine $engine = null)
    {
        echo self::fetch($file, $args, $engine);
        exit;
    }

    public static function fetch(string $file, Array $args = null, IEpiiViewEngine $engine = null)
    {
        return self::parseContent($file, $args, $engine);
    }


    public static function fetchContent($content, Array $args = null, IEpiiViewEngine $engine = null)
    {
        return self::parseContent($content, $args, $engine, false);
    }

    public static function displayContent($content, Array $args = null, IEpiiViewEngine $engine = null)
    {
        echo self::parseContent($content, $args, $engine, false);
        exit;
    }

    private static function getArgs(Array $args = null)
    {
        $out = [];
        if (self::$comon_data) {
            $out = self::$comon_data;
        }
        $out["_view"] = ["config" => self::$config, "get" => $_GET, "post" => $_POST, "cookie" => $_COOKIE, "server" => $_SERVER];

        if ($args) {
            $out = array_merge($out, $args);
        }
        return $out;
    }

    private static function parseContent(string $file, Array $args = null, IEpiiViewEngine $engine = null, $is_file = true)
    {
        if ($engine === null) {
            $engine = self::$engine;
        }

        $args = self::getArgs($args);


        if (is_string($engine)) {

            if (!class_exists($engine)) {
                echo "tmplate engine not exists!";
                exit();
            }
            $engine_mod = new $engine();
            if ($engine_mod instanceof IEpiiViewEngine) {
                $engine_mod->init(self::$config);
            }
        } else {
            $engine_mod = $engine;
        }

        if ($engine_mod instanceof IEpiiViewEngine) {

            if ($is_file)
                $out = $engine_mod->fetch($file, $args);
            else
                $out = $engine_mod->parseString($file, $args);
            if (isset(self::$replace_string[0])) {
                $out = str_replace(self::$replace_string[0], self::$replace_string[1], $out);
            }
            if (isset(self::$replace_string[2])) {
                $out = preg_replace(self::$replace_string[2], self::$replace_string[3], $out);
            }
            if (isset(self::$replace_string[4])) {
                $out = preg_replace_callback_array(self::$replace_string[4], $out);
            }

            return $out;
        } else {
            echo "It is not a right tmplate engine!";
            exit();
        }
    }
}