<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/3/19
 * Time: 4:04 PM
 */

namespace epii\admin\center\app;


use epii\admin\center\common\_controller;
use epii\admin\center\config\Settings;
use epii\admin\ui\lib\epiiadmin\jscmd\JsCmd;
use epii\server\Args;
use wangshouwei\session\Session;

class skin_change extends _controller
{
    public function save()
    {
        $type = Args::params("type");
        $name = [];
        $value = [];

        if ($type == "navbar") {
            $name[] = "nav_theme";
            $value[] = str_replace("bg-", "", Args::params("value"));
        } elseif ($type == "logo-bg") {
            $name[] = "left_top_theme";
            $v = Args::params("value");

            $value[] = str_replace("bg-", "", $v);
        } elseif ($type == "sidebar-dark") {
            $name[] = "left_selected_theme";
            $v = Args::params("value");

            $value[] = str_replace("sidebar-dark-", "", $v);

            $name[] = "left_bg_theme";
            $value[] = "dark";

        } elseif ($type == "sidebar-light") {
            $name[] = "left_selected_theme";
            $v = Args::params("value");

            $value[] = str_replace("sidebar-light-", "", $v);

            $name[] = "left_bg_theme";
            $value[] = "light";
        }

        foreach ($name as $_k => $_v) {
            Settings::set("app.style.".$_v, $value[$_k], Session::get("user_id"), 3);
        }
        echo JsCmd::make()->run();
    }
}