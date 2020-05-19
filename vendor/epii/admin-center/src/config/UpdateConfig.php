<?php

/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/3/19
 * Time: 4:59 PM
 */

namespace epii\admin\center\config;

use epii\admin\center\libs\Tools;
use epii\admin\center\ProjectConfig;
use epii\server\i\IRun;
use think\Db;

class UpdateConfig implements IRun
{

    public function run()
    {
        if (!Db::getConfig("hostname")) {
            return;
        }
        // TODO: Implement run() method.

        $dir = ProjectConfig::getAdminCenterPlusInitConfig()->get_cache_dir() . DIRECTORY_SEPARATOR . "update" . DIRECTORY_SEPARATOR;
              
        Db::transaction(
            function () use($dir){
               if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }
                if (!file_exists($file = $dir . "20190319.update")) {

                    if ($test = Db::name("setting")->find()) {
                        if (!isset($test["uid"])) {
                            Db::query("ALTER TABLE `" . Db::getConfig("prefix") . "setting` ADD `uid` INT NOT NULL DEFAULT '0' AFTER `tip`, ADD INDEX (`uid`)");
                            DB::query("ALTER TABLE `" . Db::getConfig("prefix") . "setting` DROP INDEX `name`, ADD UNIQUE `name` (`name`, `uid`) USING BTREE");
                        }
                    }


                    file_put_contents($file, 1);
                }
                if (!file_exists($file = $dir . "20190917.update")) {

                    Db::name("setting")->where("id", 9)->update(["value" => "https://epii.gitee.io/epiiadmin-js/img/AdminLTELogo.png"]);

                    file_put_contents($file, 1);
                }
                if (!file_exists($file = $dir . "20190920.update")) {

                    $info = Db::name("node")->where("id", 5)->find();
                    if (!isset($info["badge_class"])) {
                        Db::query("ALTER TABLE `" . Db::getConfig("prefix") . "node` ADD `badge_class` varchar(50) NOT NULL DEFAULT ''");

                        DB::query("update  `" . Db::getConfig("prefix") . "node` set icon='fa fa-circle-o text-info'  where id=18");
                        DB::query("update  `" . Db::getConfig("prefix") . "node` set badge_class='epii\\\\admin\\\\center\\\\menu\\\\badge_test'  where id in (5,16)");


                        Db::query("INSERT INTO `" . Db::getConfig("prefix") . "node` (`id`, `name`, `url`, `status`, `remark`, `sort`, `pid`, `icon`, `badge`, `is_open`, `open_type`) VALUES(7, '样式(adminlite3)', 'http://epii.gitee.io/adminlite3/', 1, '', 100, 0, 'fa fa-circle-o text-danger', NULL, NULL, 1)");
                        Db::query("INSERT INTO `" . Db::getConfig("prefix") . "setting` (`id`, `name`, `value`, `type`, `addtime`, `tip`) VALUES(4, 'app.menu.open', '1', 1, 1547191854, '左侧导航默认展开')");
                    }

                    file_put_contents($file, 1);
                }
            }
        );

        Db::transaction(
            function () use($dir){
                if (!file_exists($file = $dir . "20200516.update")) {

                    $info = Db::name("node")->where("id", 9)->find();
                    if (!$info) {
                        $ret = Tools::execSqlFile(__DIR__."/../data/update_sql/20200516.sql","epii_");
                        if(! $ret) return false;
                        Db::query("INSERT INTO `" . Db::getConfig("prefix") . "node` (`id`, `name`, `url`, `status`, `remark`, `sort`, `pid`, `icon`, `badge`, `is_open`, `open_type`) VALUES(8, '扩展中心', '', 1, '扩展中心', 9, 0, 'fa fa-cloud', NULL, NULL, 0)");
                        Db::query("INSERT INTO `" . Db::getConfig("prefix") . "node` (`id`, `name`, `url`, `status`, `remark`, `sort`, `pid`, `icon`, `badge`, `is_open`, `open_type`,`badge_class`) VALUES(9, '应用列表', '?app=addons@index&_vendor=1', 1, '应用列表', 1, 8, 'fa fa-cloud', NULL, NULL, 0,'epii\\\\admin\\\\center\\\\menu\\\\badge_test')");
                    }

                    file_put_contents($file, 1);
                }
                if (!file_exists($file = $dir . "2020051602.update")) {

                    $info = Db::name("node")->where("id", 9)->find();
                    if (!isset($info["addons_id"])) {
                        $ret = Tools::execSqlFile(__DIR__."/../data/update_sql/2020051602.sql","epii_");
                        if(! $ret) return false;
                     }

                    file_put_contents($file, 1);
                }

            }
        );
    }
}
