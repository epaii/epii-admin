<?php
namespace epii\app;

use epii\app\i\IAppPlusInitConfig;

/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/1/2
 * Time: 1:01 PM
 */
class AppPlusInit implements \epii\server\i\IRun
{

    private static $_appPlusInitConfig = null;

    public static function setConfig(IAppPlusInitConfig $appPlusInitConfig)
    {
        self::$_appPlusInitConfig = $appPlusInitConfig;
    }


    public function run()
    {
        // TODO: Implement run() method.
        if (self::$_appPlusInitConfig === null) {
            echo "it is need run AppPlusInit::setConfig() ";
            exit;
        }

        $config = self::$_appPlusInitConfig;
        if ($config instanceof IAppPlusInitConfig) {

            \epii\template\View::setEngine($config->get_view_config(), $config->get_view_engine());

            if ($config->get_view_engine() == \epii\template\engine\EpiiViewEngine::class) {
                \epii\template\engine\EpiiViewEngine::addFunction("url", function ($url) use ($config) {

                    return rtrim($config->get_web_url_prefix(), "/") . "/" . $url;
                });
                \epii\template\engine\EpiiViewEngine::addParser("url", function ($args) use ($config) {

                    return rtrim($config->get_web_url_prefix(), "/") . "/" . $args[0];
                });
            }


            if ($config->get_db_config())
                \think\Db::setConfig($config->get_db_config());

            if ($config->get_cache_dir())
                \epii\cache\Cache::initDir($config->get_cache_dir());

        }


    }
}