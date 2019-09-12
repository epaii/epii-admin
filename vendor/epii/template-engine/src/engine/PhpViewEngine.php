<?php
namespace epii\template\engine;

use epii\template\i\IEpiiViewEngine;


/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/12/25
 * Time: 1:19 PM
 */
class PhpViewEngine implements IEpiiViewEngine
{
    private $config = [];

    public function init(Array $config)
    {
        // TODO: Implement init() method.

        $this->config = $config;
        $this->config["tpl_dir"] = rtrim($this->config["tpl_dir"], DIRECTORY_SEPARATOR);


    }


    public function fetch(string $file, Array $args = null)
    {
        $tmpfile = $this->config["tpl_dir"] . DIRECTORY_SEPARATOR . $file . ".php";
        if (!file_exists($tmpfile)) {
            return "";
        } else {
            ob_start();
            if ($args !== null)
                extract($args);
            include_once $tmpfile;
            $content = ob_get_contents();
            ob_clean();
            return $content;
        }


    }


    public static function require_config_keys()
    {
        return ["tpl_dir"];
    }

    public function parseString(string $string, Array $args = null)
    {
        // TODO: Implement parseString() method.
        ob_start();
        if ($args !== null)
            extract($args);
        eval('?> ' . $string . ' <?php ');
        $content = ob_get_contents();
        ob_clean();
        return $content;
    }
}