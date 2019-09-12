<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/1/11
 * Time: 9:07 AM
 */

namespace epii\admin\center\config;


use epii\admin\center\ProjectConfig;
use think\Db;
use wangshouwei\session\Session;

class Settings
{
    private static $map = null;

    public static function _saveCache()
    {
        self::$map = null;
        $map = Db::name("setting")->where("uid", "0")->column("value", "name");
        return file_put_contents(self::getCachefile(), "<?php return  " . var_export($map, true) . " ;");

    }

    private static function getCachefile()
    {

        $cachedir = ($dir = ProjectConfig::getAdminCenterPlusInitConfig()->get_cache_dir() . DIRECTORY_SEPARATOR . "setting") . DIRECTORY_SEPARATOR . "setting.php";
        if (!is_dir($dir))
            mkdir($dir, 0777, true);
        return $cachedir;
    }

    public static function get($key = null, $defualt_value = "")
    {

        if (!self::$map) {
            if (!is_file($file = self::getCachefile())) {
                if (!self::_saveCache()) {
                    echo "setting cache file write error";
                    exit();
                }
            }
            self::$map = include $file;
        }


        if ($key) {
            if (is_string($key)) {
                if (isset(self::$map[$key])) return self::$map[$key];
                else return $defualt_value;
            } elseif (is_array($key)) {
                $out = [];
                foreach ($key as $item) {
                    $out[$item] = isset(self::$map[$item]) ? self::$map[$item] : $defualt_value;
                }
                return $out;
            }
        } else {
            return self::$map;
        }
        return null;
    }

    public static $user_map = null;

    public static function user($key = null, $defualt_value = "")
    {
        if (self::$user_map == null && Session::get("user_id")) {
            self::$user_map = Db::name("setting")->where("uid", Session::get("user_id"))->column("value", "name");
        }
        if (self::$user_map && isset(self::$user_map[$key])) {
            return self::$user_map[$key];
        } else {
            return $defualt_value;
        }


    }

    public static function set($name, $value, $uid, $type, $tip = "默认提示")
    {
        $data = [];
        $data['name'] = $name;
        $data['uid'] = $uid;
        if (Db::name("setting")->where($data)->find()) {
            return Db::name('setting')->where($data)->update(["value" => $value]);
        }


        $data['type'] = $type;

        $data['value'] = $value;
        $data['tip'] = $tip;

        $data['addtime'] = time();

        return Db::name('setting')->insert($data);
    }
}