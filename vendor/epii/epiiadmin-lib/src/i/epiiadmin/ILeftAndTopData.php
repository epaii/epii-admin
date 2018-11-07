<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/6/29
 * Time: ����9:09
 */

namespace wslibs\i\epiiadmin;


interface ILeftAndTopData
{
    public function getLeftTopData();

    public function getLeftMenuData();

    public function getTopRightNavs();
    public function getTheme();
    public function getLeftMenuTheme();
    public function getMenuActiveId();
    public function isMenuAllOpen();

}