<?php

namespace epii\admin\center\libs;

use epii\orm\Db;
use epii\server\Tools;

class AddonsScan
{
    private static $alladdons = null;
    public static function scan()
    {
        $dirs = AddonsManager::$__addones_one_dirs;
        $dir = AddonsManager::getAddonsDir();
        $file_arr = scandir($dir);
        foreach ($file_arr as $item) {
            if ($item != ".." && $item != ".") {
                if (is_dir($dir . "/" . $item) && file_exists($dir . "/" . $item . "/composer.json")) {
                    $dirs[] = $dir . "/" . $item;
                }
            }
        }
        $composer_list = json_decode(file_get_contents(Tools::getVendorDir() . "/composer/installed.json"), true);
        array_walk($composer_list,function (&$item) {
            $item["path"] = Tools::getVendorDir() . DIRECTORY_SEPARATOR . $item["name"];
            $item["autoload_file"] = null;
        });
        foreach ($dirs as $item) {
            $file = $item . DIRECTORY_SEPARATOR . "composer.json";
            if (file_exists($file)) {
                $autoload_file = $item . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
                $composer_list[] = array_merge(json_decode(file_get_contents($file), true), ["autoload_file" => file_exists($autoload_file) ? $autoload_file : null,"path"=>$item ]);
            }
        }
        
        $composer_list = array_filter($composer_list, function ($item) {
            return isset($item["extra"]["epii_admin_addons"]) && isset($item["extra"]["epii_admin_addons"]["title"]) && isset($item["description"]) && ( isset($item["version"]) || isset($item["extra"]["version"]) );
        });
        $list = [];
        $installinfos = Db::name("addons")->column("*","name");
       
        foreach ($composer_list as $item){
            
            $config = array_merge(["name"=>$item["name"],"version"=>isset($item["version"])?$item["version"]:"","__path_dir"=>$item["path"],"description"=>$item["description"],"autoload_file"=>$item["autoload_file"]],$item["extra"]["epii_admin_addons"]);
           
            if (isset($config["base_name_space"])) {
                if (!is_array($config["base_name_space"])) {
                    $config["base_name_space"] = [$config["base_name_space"]];
                }
            }
           
            if(isset($installinfos[$item["name"]]))
            {
                $installinfo = $installinfos[$item["name"]];
            }else{
                $installinfo = null;
            }
                $config["install"] =  $installinfo  && ($installinfo["install"]);
                $config["status"] =  $installinfo ? $installinfo["status"] : "0";
                $config["__data"] = $installinfo;
            
            $list[$item["name"]] = $config;
        }

      
        $cache_dir = Tools::getRuntimeDirectory().DIRECTORY_SEPARATOR."setting";
        Tools::mkdir($cache_dir);
        $cache_file = $cache_dir.DIRECTORY_SEPARATOR."addons.json";
        $ret = @file_put_contents($cache_file,json_encode($list,JSON_UNESCAPED_UNICODE));
        if(!$ret) return false;
        self::$alladdons = $list;
        return $list;  
    }


    public static function getAllAddons(){
        if(self::$alladdons===null)
        {
            $cache_dir = Tools::getRuntimeDirectory().DIRECTORY_SEPARATOR."setting";
      
            $cache_file = $cache_dir.DIRECTORY_SEPARATOR."addons.json";
            if(file_exists($cache_file))
            {
                self::$alladdons =  json_decode(file_get_contents($cache_file),true);
            }
        }

        return  self::$alladdons;
      
    }

    public static function getAddons($name){
        $all = self::getAllAddons();
        return isset($all[$name])?$all[$name]:null;
    }
}
