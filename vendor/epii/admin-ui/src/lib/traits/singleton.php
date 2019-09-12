<?php
namespace epii\admin\ui\lib\traits;
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/6/27
 * Time: 下午2:23
 */
trait singleton
{

    public static function getInstance()
    {
        static $_instance = NULL;
        $class = __CLASS__;
        return $_instance ?: $_instance = new $class;
    }

    public function __clone()
    {
        trigger_error('Cloning ' . __CLASS__ . ' is not allowed.', E_USER_ERROR);
    }

    public function __wakeup()
    {
        trigger_error('Unserializing ' . __CLASS__ . ' is not allowed.', E_USER_ERROR);
    }
}