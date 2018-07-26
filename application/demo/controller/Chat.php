<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/6/29
 *
 */

namespace app\demo\controller;


use wslibs\i\epiiadmin\ITopRightNavItem;

class Chat implements ITopRightNavItem
{

    public function getHtml()
    {
        // TODO: Implement getHtml() method.
        return template_parse("notice/chat");
    }
}