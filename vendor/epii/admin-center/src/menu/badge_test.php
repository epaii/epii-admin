<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/9/20
 * Time: 3:14 PM
 */

namespace epii\admin\center\menu;

use epii\admin\center\config\IBadgeInfo;

class badge_test implements IBadgeInfo
{

    private $info =[];

    public function getCssClass()
    {
        if ($this->info["id"]==5 || $this->info["id"]==9)
        {
            return "badge badge-danger";
        }else{
            return "badge badge-info";
        }

    }

    public function getText()
    {
        if ($this->info["id"]==5 || $this->info["id"]==9)
        {
            return "New";
        }else{
            return "2";
        }
    }

    public function __construct($menu_info)
    {
        $this->info = $menu_info;
    }
}