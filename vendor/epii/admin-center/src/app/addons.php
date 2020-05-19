<?php
namespace epii\admin\center\app;

use epii\admin\center\common\_controller;
use epii\admin\center\libs\AddonsManager;
use epii\admin\center\libs\AddonsScan;
use epii\admin\ui\lib\epiiadmin\jscmd\JsCmd;
use epii\orm\Db;
use epii\server\Args;

class addons extends _controller{
    public function index(){
     
    
        $this->adminUiDisplay('addons/index', "", ["version" => time()]);
    }

    public function scan(){
       $ok =   AddonsScan::scan();
       if(!$ok) return JsCmd::alert("失败");
       return JsCmd::alertRefresh("成功");
    }
    public function ajaxdata()
    { 

        $all =   AddonsScan::scan();
        
        if(!$all) $all=[];
        foreach ($all as $key=>$value){
            if($value["__data"])
            {
                $all[$key]["addtime"] = date("Y-m-d",$value['__data']["addtime"]);
            }else{
                $all[$key]["addtime"] = "";
            }
        }

        $outdata = ["rows" =>array_values($all), "total" => count($all)];
        
        echo  json_encode($outdata, JSON_UNESCAPED_UNICODE);
    }
    public function status(){
        $ret = Db::transaction(function(){
            $out = false;
            $name = Args::params("name/1");
            Db::name("addons")->where("name",$name)->update(["status"=>Args::params("status/d")]);
            $info = DB::name("addons")->where("name",$name)->find();
            if($info["menu_ids"])
            {
                Db::name('node')->whereIn("id",explode(",",$info["menu_ids"]))->update(["status"=>Args::params("status/d")]);
            }
            $app = AddonsManager::getAddonsApp($name);
            if($app){
                if(Args::params("status/d")){
                   $out = $app->onOpen();
                }else{
                    $out =  $app->onClose();
                }
            }
            if($out){
                AddonsScan::scan();
            }
            return false;
        });
      
        if( $ret )
        return JsCmd::alertRefresh("操作成功");
        else return JsCmd::alert("操作失败");
    }

    public function install(){
        $name = Args::params("name/1");
       
        $info = AddonsManager::getAddonsConfig($name);
        if(!$info){
            return JsCmd::alert("扩展不存在");
        }
        if($info["install"]){
            return JsCmd::alert("扩展已经安装");
        }
        $ret = AddonsManager::install($name);
        if(!$ret){
            return JsCmd::alert("安装失败");
        }
        return JsCmd::alertRefresh("安装成功");

    }
}

