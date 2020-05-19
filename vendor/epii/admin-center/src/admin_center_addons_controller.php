<?php
 

namespace epii\admin\center;

use epii\admin\center\libs\AddonsManager;
use epii\orm\Db;
use epii\template\engine\EpiiViewEngine;
 

class admin_center_addons_controller extends admin_center_controller
{
    protected $addons_info = [];
    protected $addons_config = [];
    public function init()
    {
         $cache_dir = ProjectConfig::getAdminCenterPlusInitConfig()->get_cache_dir() . DIRECTORY_SEPARATOR . "addons" . DIRECTORY_SEPARATOR;
     
         parent::init();
         $addonsname = AddonsManager::getCurrentAddonsName();
         $config = AddonsManager::getAddonsConfig($addonsname);
         
         $engine = new EpiiViewEngine();
         $engine->init(["tpl_dir"=> $config["__path_dir"].DIRECTORY_SEPARATOR."view","cache_dir"=>$cache_dir.$addonsname]);
         $this->setViewEngine($engine);
         $this->addons_info = $config;
         $this->addons_config = Db::name("setting")->where("addons_id", $config["__data"]["id"])->column("value","name");
         
         
    }


}