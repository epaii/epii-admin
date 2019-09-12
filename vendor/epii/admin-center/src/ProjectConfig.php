<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/1/9
 * Time: 10:54 AM
 */

namespace epii\admin\center;


use epii\admin\center\config\AdminCenterPlusInitConfig;
use epii\admin\center\config\AdminCenterUiConfig;
use epii\admin\center\config\LoginPageConfig;
use epii\ui\login\IloginConfig;


class ProjectConfig
{
    private static $adminUi = null;
    private static $AdminCenterPlusInitConfig = null;
    private static $loginConfig = null;

    public static function _setAdminUiConfig(AdminCenterUiConfig $adminUi)
    {
        self::$adminUi = $adminUi;
    }

    public static function getAdminUiConfig(): AdminCenterUiConfig
    {
        if (!self::$adminUi)
            self::$adminUi = new AdminCenterUiConfig();
        return self::$adminUi;
    }

    public static function _setLoginPageConfig(IloginConfig $loginConfig)
    {
        self::$loginConfig = $loginConfig;
    }

    public static function getLoginPageConfig(): IloginConfig
    {
        if (!self::$loginConfig)
            self::$loginConfig = new LoginPageConfig();
        return self::$loginConfig;
    }

    public static function _setAdminCenterPlusInitConfig(AdminCenterPlusInitConfig $AdminCenterPlusInitConfig)
    {
        self::$AdminCenterPlusInitConfig = $AdminCenterPlusInitConfig;
    }

    public static function getAdminCenterPlusInitConfig(): AdminCenterPlusInitConfig
    {
        return self::$AdminCenterPlusInitConfig;
    }


}