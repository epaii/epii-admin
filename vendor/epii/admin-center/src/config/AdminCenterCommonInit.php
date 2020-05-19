<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/1/9
 * Time: 9:57 AM
 */

namespace epii\admin\center\config;


use epii\admin\ui\EpiiAdminUi;
use epii\server\Args;
use epii\server\i\IRun;
use epii\template\engine\EpiiViewEngine;
use epii\ui\upload\AdminUiUpload;
use wangshouwei\session\Session;

class AdminCenterCommonInit implements IRun
{

    public function run()
    {
        // TODO: Implement run() method.

        EpiiViewEngine::addParser("url", function ($args) {

            return "?app=" . (isset($args[0])?$args[0]:"") . "@" . (isset($args[1])?$args[1]:"") . "&" . (isset($args[2]) ? $args[2] : "");
        });
        EpiiViewEngine::addParser("args", function ($args) {

            return Args::params($args[0], isset($args[1]) ? $args[1] : "");
        });
        EpiiViewEngine::addFunction("input", function ($text, $name, $defualt_value = "", $tip = "", $other = "", $type = "text") {


            return "<div class=\"form-group\"><label>{$text}：</label><input type=\"{$type}\" class=\"form-control\" name=\"{$name}\" value='{$defualt_value}' {$other} placeholder=\"{$tip}\"></div>";
        });
        EpiiViewEngine::addParser("input", function ($args) {


            $args = array_merge(["value" => "", "tip" => "", "required" => "", "readonly" => "", "type" => "text"], $args);
            if ($args["required"]) {
                $args["required"] = "required";
            }
            if ($args["readonly"]) {
                $args["required"] = "readonly";
            }
            return "<div class=\"form-group\"><label>{$args["text"]}：</label><input type=\"{$args["type"]}\" class=\"form-control\" name=\"{$args["name"]}\" value='{$args["value"]}' {$args["required"]} placeholder=\"{$args["tip"]}\"></div>";

        });



        AdminUiUpload::init("?app=upload@img&_vendor=1");
        EpiiAdminUi::addPluginData("skin_save_api", "?app=skin_change@save&_vendor=1&type={type}&value={value}");

        EpiiAdminUi::addPluginData("menu_badge_api","?app=menu_badge_api@index&_vendor=1");

        // AdminUiUpload::init()
    }
}