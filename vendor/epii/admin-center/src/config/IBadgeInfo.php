<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/1/23
 * Time: 5:27 PM
 */

namespace epii\admin\center\config;


interface IBadgeInfo
{
    public function __construct($menu_info);

    public function getCssClass();

    public function getText();
}