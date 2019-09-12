<?php

namespace wangshouwei\session;

/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/1/9
 * Time: 10:34 AM
 */
class Session
{
    private static $is_start = false;

    public static function start(\SessionHandlerInterface $s = null)
    {
        if (self::$is_start) return;
        if ($s !== null) {
            session_set_save_handler($s, true);
        }
        self::$is_start = session_start();
    }

    public static function set($key, $val = null)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $_SESSION[$k] = $v;
            }
        } else
            $_SESSION[$key] = $val;
    }

    public static function get($key = null)
    {
        if ($key) {
            if (isset($_SESSION[$key])) {
                return $_SESSION[$key];
            } else {
                return null;
            }
        } else {
            return $_SESSION;
        }
    }

    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function del($key)
    {
        if (self::has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public static function empty()
    {
        $_SESSION = [];
    }
}