<?php

namespace epii\template\i;
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/12/25
 * Time: 1:07 PM
 */
interface IEpiiViewEngine
{
    public static function require_config_keys();

    public function init(Array $config);

    public function fetch(string $file, Array $args=null);
    public function parseString(string $string, Array $args=null);
}