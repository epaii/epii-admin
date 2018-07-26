<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/6/29
 * Time: ����9:47
 */

namespace app\demo\controller;


use wslibs\i\epiiadmin\ITopRightNavItem;

class Notice implements ITopRightNavItem
{
    public function noticelist()
    {

    }

    public function getHtml()
    {
        // TODO: Implement getHtml() method.
        return template_parse("notice/innav");
    }
}