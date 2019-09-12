<?php

namespace epii\ui\login;

use epii\admin\ui\EpiiAdminUi;
use epii\admin\ui\lib\epiiadmin\jscmd\Alert;
use epii\admin\ui\lib\epiiadmin\jscmd\JsCmd;

/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/1/8
 * Time: 1:09 PM
 */
class AdminLogin
{

    private static $d_config = [
        "title" => "后台登录",
        "success_url" => "",
        "bg_imgs" => [
            "http://epii.gitee.io/static/imgs/login_imgs/login1.jpg",
            "http://epii.gitee.io/static/imgs/login_imgs/login2.jpg",
            "http://epii.gitee.io/static/imgs/login_imgs/login3.jpg",
            "http://epii.gitee.io/static/imgs/login_imgs/login4.jpg"],
        "username_tip" => "用户名或电子邮件",
        "password_tip" => "密　码",
        "btn_msg" => "登 录"

    ];

    public static function login(IloginConfig $config)
    {

        $config_value = $config->getConfigs();

        if ($config_value) {
            $config_value = array_merge(self::$d_config, $config_value);
        } else {
            $config_value = self::$d_config;
        }


        if (!$config_value["success_url"]) {
            echo "admin ui login config must include success_url ";
            exit;
        }

        if ($_POST) {

            $ret = $config->onPost($_POST["username"], $_POST["password"], $error_msg);

            if ($ret) {
                if ($error_msg)
                    echo JsCmd::alertUrl($config_value["success_url"], $error_msg);
                else
                    echo JsCmd::url($config_value["success_url"]);

            } else {

                echo JsCmd::make()->addCmd(Alert::make()->msg($error_msg)->onOk(null))->run();
            }
            exit;
        } else {
            ob_start();
            $bg_imgs = $config_value["bg_imgs"];
            if (!in_array(count($bg_imgs), [1, 4])) {
                echo "admin ui login must include 4 imgs ";
                exit;
            }
            $title = $config_value["title"];
            include_once __DIR__ . "/html/login.php";
            $conetnt = ob_get_clean();
            EpiiAdminUi::showPage($conetnt);

        }
    }
}

