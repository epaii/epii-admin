<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/6/29
 * Time: ����9:09
 */

namespace epii\admin\ui\lib\i\epiiadmin;


use epii\admin\ui\lib\epiiadmin\MenuConfig;
use epii\admin\ui\lib\epiiadmin\SiteConfig;

interface IEpiiAdminUi
{


    public function getConfig(): SiteConfig;

    public function getLeftMenuData(): MenuConfig;

    public function getTopRightNavHtml(): string ;

}