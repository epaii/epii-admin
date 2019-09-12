<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/1/11
 * Time: 9:32 AM
 */

namespace epii\admin\center\config;


use epii\admin\center\libs\Tools;
use epii\admin\center\ProjectConfig;

use epii\tools\classes\ClassTools;
use think\Db;

class Rbac
{
    private static $map = null;

    public static function _saveCache()
    {
        self::$map = null;
        $list = Db::name("role")->select();

        $roles = ["type" => [], "info" => []];


        if ($list) {

            $name_pre = Tools::getEnableNameSpacePre();


            $all_roles = ClassTools::get_all_classes_and_methods($name_pre);

            foreach ($all_roles as $class => $ms) {
                foreach ($ms as $metod) {
                    $roles["info"][$class . "@" . $metod] = [];
                }
            }


            foreach ($list as $key => $value) {
                $info = json_decode($value["powers"], true);
                if ($info) {
                    $roles["type"][$value["id"]] = $info["type"];

                    if ($info["power"]) {
                        foreach ($info["power"] as $_c => $_m) {
                            foreach ($_m as $__m) {
                                $roles["info"][$_c . "@" . $__m][] = $value["id"];
                            }
                        }
                    }


                }
            }

            return file_put_contents(self::getCachefile(), "<?php return  " . var_export($roles, true) . " ;");
        } else {
            return false;
        }


    }

    private static function getCachefile()
    {

        $cachedir = ($dir = ProjectConfig::getAdminCenterPlusInitConfig()->get_cache_dir() . DIRECTORY_SEPARATOR . "setting") . DIRECTORY_SEPARATOR . "roles.php";
        if (!is_dir($dir))
            mkdir($dir, 0777, true);
        return $cachedir;
    }

    public static function check(int $groud_id, $string)
    {
        if (!self::$map) {
            if (!is_file($file = self::getCachefile())) {
                if (!self::_saveCache()) {
                    echo "setting roles file write error";
                    exit();
                }
            }
            self::$map = include $file;
        }



        if (!isset(self::$map["type"][$groud_id])) {
            return false;
        }
        $type = self::$map["type"][$groud_id];

        $type_bool = false;
        if ($type == 2) $type_bool = true;

        if (!isset(self::$map["info"][$string])) return $type_bool;

        if (in_array($groud_id, self::$map["info"][$string])) {
            return !$type_bool;
        } else {
            return $type_bool;
        }


    }
}