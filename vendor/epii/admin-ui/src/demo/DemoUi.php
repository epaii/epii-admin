<?php

namespace epii\admin\ui\demo;

use epii\admin\ui\lib\epiiadmin\MenuConfig;
use epii\admin\ui\lib\epiiadmin\SiteConfig;
use epii\admin\ui\lib\i\epiiadmin\IEpiiAdminUi;

/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/12/28
 * Time: 2:03 PM
 */
class DemoUi implements IEpiiAdminUi
{

    public function getConfig(): SiteConfig
    {
        // TODO: Implement getConfig() method.
        $sitconfig = new SiteConfig();
        $sitconfig->user_name("张三")->app_theme(SiteConfig::app_theme_success)->app_left_theme(SiteConfig::app_left_theme_dark);
        return $sitconfig;
    }

    public function getLeftMenuData(): MenuConfig
    {


        $m_config = new MenuConfig();
        $m_config->addMenu(1, 0, "仪表盘", "", "fa fa-dashboard");
        $m_config->addMenu(2, 1, "仪表盘3", "http://www.baidu.com", "fa fa-circle-o");

        $m_config->addMenuHeader("小组件");
        $m_config->addMenu(5, 0, "开发文档", "http://docs.epii-admin.epii.cn", "fa fa-dashboard",null,null,true);
        $m_config->selectId(2)->isAllOpen(true);

        return $m_config;

    }

    public function getTopRightNavHtml(): string
    {
        // TODO: Implement getTopRightNavs() method.
        return "";
    }


}