<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/9/29
 * Time: 3:11 PM
 */

namespace epii\admin\center\app;


use epii\admin\center\common\_controller;
use epii\admin\center\ProjectConfig;
use epii\server\Args;
use epii\server\Response;
use think\Db;

class menu_badge_api extends _controller
{
    public function index()
    {
        $query = DB::name("node")->where("badge_class", "<>", '');
        $menu_id = Args::params("menu_id");

        if ($menu_id) {
            $menu_id = explode(",", $menu_id);
            $query->whereIn("id", $menu_id);
        }
        $list = $query->select();
        $outlist = [];
        foreach ($list as $menu) {


            $binfo = ProjectConfig::getAdminUiConfig()->getMenuBadgeInfo($menu);
            $b_class = null;
            $b_text = null;
            if ($binfo) {
                $b_class = $binfo->getCssClass();
                $b_text = $binfo->getText();
                if ($b_text)
                    $outlist[] = ["id" => "tab_" . $menu["id"], "span" => "<span class=\"right " . $b_class . "\">" . $b_text . "</span>"];
            }
            // $b_text =5;

        }

        Response::success(["list" => $outlist]);
    }
}