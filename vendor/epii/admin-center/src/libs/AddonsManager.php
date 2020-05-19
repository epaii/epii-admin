<?php

namespace epii\admin\center\libs;

use epii\orm\Db;
use epii\server\App;
use epii\server\Args;
use epii\server\i\IRun;
use epii\server\Response;

class AddonsManager implements IRun
{

    private static $__addones_dir = null;
    public static $__addones_one_dirs = [];

    public static function getAddonsDir()
    {
        if (self::$__addones_dir === null) {
            return Tools::getVendorDir() . "/../addons";
        }
        return self::$__addones_dir;
    }
    public static function getAllAddons()
    {
        return AddonsScan::getAllAddons();
    }
    public static function setAddonsDir($dir)
    {
        self::$__addones_dir = rtrim($dir, DIRECTORY_SEPARATOR);
    }
    public static function addAddonsPath($PathToOne)
    {
        self::$__addones_one_dirs[] = rtrim($PathToOne, DIRECTORY_SEPARATOR);
    }
    public static function getCurrentAddonsName()
    {
        return Args::params("__addons", null);
    }
    public static function getCurrentAddonsConfig()
    {
        $addonsname = self::getCurrentAddonsName();
        if ($addonsname) {
            return self::getAddonsConfig($addonsname);
        }
        return null;
    }

    public static function getAddonsConfig($addons_name)
    {
        return AddonsScan::getAddons($addons_name);
    }
    public static function error($msg)
    {
        Response::error($msg);
    }
  
    public static function loadAddons($name)
    {
        $config = self::getAddonsConfig($name);
        if (!$config) {

            return false;
        }

        if ($config["autoload_file"] && is_file($config["autoload_file"])) {
            include_once $config["autoload_file"];
        }

        return $config;
    }
    public static function getAddonsApp($name)
    {

        $config = self::loadAddons($name);
        if ($config && isset($config["app"])) {
            $app = $config["app"];
            if (!class_exists($app)) {
                return false;
            }
            $app_obj = new $app();
            if (!($app_obj instanceof AddonsApp)) {
                return false;
            }
            if(isset($config["__data"]) && $config["__data"])
             $app_obj->setConfig(isset($config["__data"]["id"])?$config["__data"]["id"]:0,$config);
            return $app_obj;
        }
        return false;
    }

    public static function install($name)
    {
        $out =   Db::transaction(function () use ($name) {
            $is__addons_development = self::isAddonsDevelopment($name);
            $config = self::loadAddons($name);
            if (!$config) {
                return false;
            }
            $id =  Db::name("addons")->insertGetId(["name" => $config["name"], "title" => $config["title"], "addtime" => 0, "status" => 0, "version" => $config["version"], "subject" => $config["description"]]);
            if (!$id) return false;
            if (!$is__addons_development) {
                $app_obj = self::getAddonsApp($name);
                if ($app_obj) {
                    $app_obj->setConfig($id, $config);
                    $ret =  $app_obj->install();
                    if (!$ret) return false;
                }
            }
            $ret1 =  Db::name("addons")->where("id", $id)->update(["install" => 1, "status" => 1, "addtime" => time()]);
            if ($ret1) return true;
            return false;
        });
        if($out){
            AddonsScan::scan();
        }
        return $out;
    }

    public static function isAddonsDevelopment($name=null){
        $addons = $name?$name:Args::getVal("__addons");
        return Args::configVal("__addons_development") && $addons && ($addons===Args::configVal("__addons_development_name"));
     
    }

    public   function run()
    {
      
       
        $addonsname = self::getCurrentAddonsName();
        if(! $addonsname) return;
        $is__addons_development = self::isAddonsDevelopment();
       
        $config =  self::loadAddons($addonsname);
        if(!$config){
            if($is__addons_development)
            {
                AddonsScan::scan();
                $config =  self::loadAddons($addonsname);
            }else{
                self::error("模块没安装");
            }
           
        }
        if ($config && isset($config["base_name_space"]) && $config["base_name_space"]) {
            foreach ($config["base_name_space"] as $class_pre) {
                App::getInstance()->setBaseNameSpace($class_pre);
            }
        }
      
        if ($config  && !$config["install"]) {
             
            if($is__addons_development){
                if(!self::install($addonsname)){
                    self::error("模块没有自动安装成功");
                }
                $config = self::loadAddons($addonsname);
            }else 
                self::error("模块没有安装");
        }
        if ($config   && !$config["status"]) {
            self::error("模块已经关闭");
        }
        $cinfo = $config;
        if ($cinfo && $cinfo["install"] && !$is__addons_development) {
            if ($cinfo["__data"]["version"] != $cinfo["version"]) {
                $app_obj = self::getAddonsApp($addonsname);
                if ( (!$app_obj) || !($app_obj instanceof AddonsApp)) {
                    return false;
                }
                if ($app_obj->update($cinfo["version"], $cinfo["__data"]["version"])) {
                    Db::name("addons")->where("name", $cinfo["name"])->update(["version" => $cinfo["version"]]);
                } else {
                    self::error("模块更新失败");
                }
            }
        }
    }
}
