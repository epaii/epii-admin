<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/1/2
 * Time: 2:08 PM
 */

namespace epii\app;


use epii\app\i\IAppPlusInitConfig;


class App extends \epii\server\App
{
    public function setConfig(IAppPlusInitConfig $appPlusInitConfig)
    {
        AppPlusInit::setConfig($appPlusInitConfig);
        $this->init_unshift(AppPlusInit::class);
        return $this;
    }
}