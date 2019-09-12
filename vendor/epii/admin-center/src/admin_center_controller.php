<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/1/10
 * Time: 1:54 PM
 */

namespace epii\admin\center;


use epii\admin\center\app\install;
use epii\admin\center\app\root;
use epii\admin\center\app\user;
use epii\admin\center\config\Rbac;
use epii\admin\center\libs\Tools;
use epii\app\controller;
use epii\server\Args;
use wangshouwei\session\Session;

class admin_center_controller extends controller
{
    public function init()
    {
        if (Args::getVal("_show_runner")) {
            echo get_class(\epii\server\App::getInstance()->getRunner()[0]) . "@" . \epii\server\App::getInstance()->getRunner()[1];
            exit;
        }

        if (Args::getVal("ref") === "addtabs") {
            header("location:".Tools::get_web_root()."/?_code_id=".Args::getVal("_code_id"));
            exit;
        }


        $c_class = get_class(\epii\server\App::getInstance()->getRunner()[0]);

        $c_action = \epii\server\App::getInstance()->getRunner()[1];

        if ($c_class === user::class && $c_action == "logout") {
            return;
        }


        $is_login = ($c_class === root::class && $c_action === "start")|| $c_class==install::class;
        if ((!Session::get("is_login") || Session::get("is_login") == "null") && !$is_login) {
            header("location:" . Tools::get_web_root());
        }

        if (!$is_login && !Session::get("admin_gid")) {
            echo "who you are? and which your group join in?";
            exit;
        }


        if (!$is_login && (Session::get("admin_gid") != 1) && !Rbac::check(Session::get("admin_gid"), get_class(\epii\server\App::getInstance()->getRunner()[0]) . "@" . \epii\server\App::getInstance()->getRunner()[1])) {
            echo "Permission denied;";
            exit;
        }
        parent::init();


    }
}