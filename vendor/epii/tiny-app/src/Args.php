<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/11/9
 * Time: 9:41 AM
 */

namespace epii\server;


class Args
{

    // store options
    private static $optsArr = [];
    // store args
    private static $argsArr = [];
    // 是否解析过
    private static $isParse = false;

    private static $keysForArgValues = [];

    private static $configs = [];

    private static $iscli = null;

    private static $filters = [];


    public static function setFilter(callable ...$filter)
    {
        self::$filters = array_merge(self::$filters, $filter);
    }

    public static function isPost()
    {
        return isset($_SERVER['REQUEST_METHOD']) && (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST');

    }

    public static function isGet()
    {
        return isset($_SERVER['REQUEST_METHOD']) && (strtoupper($_SERVER['REQUEST_METHOD']) == 'GET');
    }

    public static function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }

    public static function is_cli()
    {
        global $argv;
        if ($argv) {
            return true;
        }
        if (self::$iscli === null) {
            self::$iscli = preg_match("/cli/i", php_sapi_name()) ? true : false;
        }
        return self::$iscli;
    }


    public static function cli_parse()
    {
        if (self::is_cli() && !self::$isParse) {
            self::parseArgs();
        }
    }

    public static function listParams(...$keys)
    {
        $out = [];
        foreach ($keys as $key) {
            $out[] = self::params($key);
        }
        return $out;
    }


    /**
     * 获取选项值
     * @param string|NULL $opt
     * @return array|string|NULL
     */
    public static function optVal($index = NULL, $default = null)
    {

        return self::__value_from_array(self::$optsArr, $index, $default);

    }


    /**
     * 获取命令行参数值
     * @param integer|NULL $index
     * @return array|string|NULL
     */
    public static function argVal($index = NULL, $default = null)
    {

        return self::__value_from_array(self::$argsArr, $index, $default);
    }


    private function __construct()
    {


    }

    public static function setConfig($config, $value = null)
    {
        if (is_array($config))
            self::$configs = array_merge(self::$configs, $config);
        else if (is_string($config)) {
            self::$configs[$config] = $value;
        }
    }

    public static function setValue($config, $value = null)
    {
        self::setConfig($config, $value);

    }


    public static function params($index = null, $default = null)
    {

        $all = [];
        $all = array_merge($all, self::$configs);
        if (self::is_cli()) {
            $all = array_merge($all, self::$argsArr, self::$optsArr);
        } else {
            $all = array_merge($all, isset($_SESSION) && $_SESSION ? $_SESSION : [], isset($_COOKIE) && $_COOKIE ? $_COOKIE : [], $_REQUEST ? $_REQUEST : []);
        }

        return self::__value_from_array($all, $index, $default);

    }

    public static function val($key, $default = null)
    {
        return self::params($key, $default);
    }

    public static function configVal($index = NULL, $default = null)
    {

        return self::__value_from_array(self::$configs, $index, $default);
    }

    /**
     * 获取命令行参数值
     * @param integer|NULL $index
     * @return array|string|NULL
     */
    public static function getVal($index = NULL, $default = null)
    {
        return self::__value_from_array($_GET, $index, $default);
    }


    public static function postVal($index = NULL, $default = null)
    {
        if (!$_POST) $_POST = [];
        return self::__value_from_array($_POST, $index, $default);

    }

    /**
     * 获取命令行参数值
     * @param integer|NULL $index
     * @return array|string|NULL
     */
    public static function cookieVal($index = NULL, $default = null)
    {
        return self::__value_from_array($_COOKIE, $index, $default);
    }

    /**
     * 获取命令行参数值
     * @param integer|NULL $index
     * @return array|string|NULL
     */
    public static function sessionVal($index = NULL, $default = null)
    {
        return self::__value_from_array($_SESSION, $index, $default);
    }


    private static function __value_from_array(&$data, $index = NULL, $default = null)
    {

        if (is_null($index)) {
            return $data;
        } else {

            $formate = null;
            if (is_string($index)) {
                $tmp = explode("/", $index);
                $index = $tmp[0];
                if (isset($tmp[1])) {
                    $formate = array_slice($tmp, 1);
                }
                $tmp = explode("|", $index);
                $index = $tmp[0];
                if (isset($tmp[1])) {
                    $default = $tmp[1];
                }
            }

            $must_has = $formate && in_array(1, $formate);

            $is_default_value = false;
            if (isset($data[$index])) {
                $value = $data[$index];
                $must_err = $must_has && !$value;
            } else {
                $must_err = $must_has;
                $value = $default;
                $is_default_value = true;
            }
            if ($must_err) {
                Console::error($default ? $default : $index . "不能为空");
            }

            if (is_string($value)) {
                $value = trim($value);


                foreach (self::$filters as $filter) {
                    $value = $filter($value);
                }


                if ($formate && strlen($value) > 0) {
                    if (in_array("d", $formate)) {
                        $value = (int)$value;
                    } else if (in_array("j", $formate) || in_array("json", $formate)) {
                        $value = json_decode($value, true);
                    } else if (in_array("explode", $formate )|| in_array("e", $formate)|| in_array("split", $formate)) {
                        $value = urldecode($value);
                        if (stripos($value, ",") !== false) {
                            $value = explode(",", $value);
                        } elseif (stripos($value, ";") !== false) {
                            $value = explode(";", $value);
                        }

                    } else if (in_array("b", $formate)) {
                        $value = $value ? true : false;
                    } else if (in_array("f", $formate)) {
                        $value = floatval($value);
                    } else if (in_array("email", $formate)) {
                        Validator::isEmail($value, (!$is_default_value) && $default ? $default : $index . "不是有效的邮箱格式");
                    } else if (in_array("phone", $formate)) {
                        Validator::isPhone($value, (!$is_default_value) && $default ? $default : $index . "不是有效手机号格式");
                    } else if (in_array("idcard", $formate)) {
                        Validator::isIdCardNumber($value, (!$is_default_value) && $default ? $default : $index . "不是有效的身份证格式");
                    }
                }


            }
            return $value;
        }


    }


    /**
     * 是否是 -s 形式的短选项
     * @param string $opt
     * @return string|boolean 返回短选项名
     */
    private static function isShortOptions($opt)
    {
        if (preg_match('/^\-([a-zA-Z0-9])$/', $opt, $matchs)) {
            return $matchs[1];
        }
        return false;
    }

    /**
     * 是否是 -svalue 形式的短选项
     * @param string $opt
     * @return array|boolean 返回短选项名以及选项值
     */
    private static function isShortOptionsWithValue($opt)
    {
        if (preg_match('/^\-([a-zA-Z0-9])(\S+)$/', $opt, $matchs)) {
            return [$matchs[1], $matchs[2]];
        }
        return false;
    }

    /**
     * 是否是 --longopts 形式的长选项
     * @param string $opt
     * @return string|boolean 返回长选项名
     */
    private static function isLongOptions($opt)
    {
        if (preg_match('/^\-\-([a-zA-Z0-9\-_]{2,})$/', $opt, $matchs)) {
            return $matchs[1];
        }
        return false;
    }

    /**
     * 是否是 --longopts=value 形式的长选项
     * @param string $opt
     * @return array|boolean 返回长选项名及选项值
     */
    private static function isLongOptionsWithValue($opt)
    {
        if (preg_match('/^\-\-([a-zA-Z0-9\-_]{2,})(?:\=(.*?))$/', $opt, $matchs)) {
            return [$matchs[1], $matchs[2]];
        }
        return false;
    }

    /**
     * 是否是命令行参数
     * @param string $value
     * @return boolean
     */
    private static function isArg($value)
    {
        return !preg_match('/^\-/', $value);
    }

    /**
     * 解析命令行参数
     *
     */
    public final static function parseArgs()
    {
        global $argv;
        if (!self::$isParse) {
            // index start from one
            $index = 1;
            $length = count($argv);
            $args_values = [];
            while ($index < $length) {
                // current value
                $curVal = $argv[$index];
                // check, short or long options
                if (($key = self::isShortOptions($curVal)) || ($key = self::isLongOptions($curVal))) {
                    // go ahead
                    $index++;
                    if (isset($argv[$index]) && self::isArg($argv[$index])) {
                        self::$optsArr[$key] = $argv[$index];
                    } else {
                        self::$optsArr[$key] = true;
                        // back away
                        $index--;
                    }
                } // check, short or long options with value
                else if (($key = self::isShortOptionsWithValue($curVal))
                    || ($key = self::isLongOptionsWithValue($curVal))
                ) {
                    self::$optsArr[$key[0]] = $key[1];
                } // args
                else if (self::isArg($curVal)) {
                    $args_values[] = $curVal;
                }
                // incr index
                $index++;
            }

            self::$argsArr = $args_values;

            self::$isParse = true;
        }

    }


    public static function setKeysForArgValues($keys)
    {

        if (!self::$keysForArgValues) {

            self::$keysForArgValues = $keys;
            $args_values = self::$argsArr;
            self::$argsArr = [];
            for ($_i = 0; $_i < count(self::$keysForArgValues); $_i++) {
                self::$argsArr[self::$keysForArgValues[$_i]] = isset($args_values[$_i]) ? $args_values[$_i] : null;
            }

        }
    }


}