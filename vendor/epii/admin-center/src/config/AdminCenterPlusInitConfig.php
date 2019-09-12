<?php

namespace epii\admin\center\config;

use epii\admin\center\libs\Tools;

use epii\app\i\IAppPlusInitConfig;

/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/1/9
 * Time: 9:54 AM
 */
 class AdminCenterPlusInitConfig implements IAppPlusInitConfig
{

    public function get_view_engine(): string
    {
        // TODO: Implement get_view_engine() method.
        return \epii\template\engine\EpiiViewEngine::class;
    }


    public function get_web_url_prefix(): string
    {
        // TODO: Implement get_web_url_prefix() method.
        return Tools::get_current_url();
    }


    public function get_cache_dir(): string
    {
        // TODO: Implement get_cache_dir() method.
        return Tools::getVendorDir() . "/../runtime/cache";
    }
    public function get_view_config(): array
    {
        // TODO: Implement get_view_config() method.
        return ["tpl_dir" => Tools::getVendorDir()  . "/../view/", "cache_dir" => Tools::getVendorDir()  . "/../runtime/cache/view/"];
    }
    public function get_db_config(): array
    {


        // TODO: Implement get_db_config() method.
        if (file_exists($db_config = Tools::getVendorDir()."/../config/db.conf.php"))

        {

            return include $db_config;
        }else{
            return [];
        }
    }

}