<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/9/5
 * Time: 5:17 PM
 */

namespace epii\server;


class Validator
{
    private static function out($out, $tip, $msg)
    {

        if (!$out) {
            
            if ($tip !== false)
                Response::error($tip === true ? $msg : $tip);
        }
        return $out;
    }

    public static function isNonempty(string $str, $tip = false)
    {
        $str = trim($str);
        $out = empty($str) ? false : true;

        return self::out($out, $tip, "不能为空");
    }

    public static function isEmail($str, $tip = false)
    {

        $out = self::isNonempty($str, $tip);

        if ($out)
            $out = preg_match("/([a-z0-9]*[-_\.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?/i", $str) ? true : false;
        return self::out($out, $tip, "邮箱格式验证失败");
    }

    public static function isPhone($phone, $tip = false)
    {
        $exp = "/^1\d{10}$/";
        $out = preg_match($exp, $phone);
        return self::out($out, $tip, "手机号格式验证失败");
    }

    public static function isIdCardNumber($idcard, $tip = false)
    {
        $out = strlen($idcard) == 15 || strlen($idcard) == 18;

        return self::out($out, $tip, "身份证号验证失败");
    }
}