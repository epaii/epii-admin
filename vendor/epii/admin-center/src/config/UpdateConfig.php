<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/3/19
 * Time: 4:59 PM
 */

namespace epii\admin\center\config;


use epii\admin\center\ProjectConfig;
use epii\server\i\IRun;
use think\Db;

class UpdateConfig implements IRun
{

    public function run()
    {
        // TODO: Implement run() method.
        $dir = ProjectConfig::getAdminCenterPlusInitConfig()->get_cache_dir() . DIRECTORY_SEPARATOR . "update";
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        if (!file_exists($file = $dir . "20190319.update")) {

            if ($test = Db::name("setting")->find())
            {
                if (!isset($test["uid"]))
                {
                    Db::query("ALTER TABLE `".Db::getConfig("prefix")."setting` ADD `uid` INT NOT NULL DEFAULT '0' AFTER `tip`, ADD INDEX (`uid`)");
                    DB::query("ALTER TABLE `".Db::getConfig("prefix")."setting` DROP INDEX `name`, ADD UNIQUE `name` (`name`, `uid`) USING BTREE");
                }
            }


            file_put_contents($file, 1);
        }
    }
}