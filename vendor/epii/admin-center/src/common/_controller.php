<?php

namespace epii\admin\center\common;

use epii\admin\center\admin_center_controller;

use epii\admin\center\libs\Tools;
use epii\template\engine\EpiiViewEngine;

/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/1/9
 * Time: 10:51 AM
 */
class _controller extends admin_center_controller
{


    public function init()
    {

        $engin = new EpiiViewEngine();
        $engin->init(["tpl_dir" => __DIR__ . "/../view/", "cache_dir" => Tools::getVendorDir()  . "/../runtime/cache/view/"]);
        $this->setViewEngine($engin);
        parent::init();
    }


}