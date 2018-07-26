<?php
namespace app\demo\model;

use think\facade\Env;
use think\facade\Url;
use wslibs\i\epiiadmin\ILeftAndTopData;

/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/6/29
 * Time: 上午9:14
 */
class Epiiadmin implements ILeftAndTopData
{



    public function __construct($args=[])
    {

    }

    public function getLeftTopData()
    {
        // TODO: Implement getLeftTopData() method.
        return ["user_avatar" => STATIC_URL_ROOT . "/img/user2-160x160.jpg",
            "user_name" => "Alexander Pierce",
            "site_logo" => STATIC_URL_ROOT . "/img/AdminLTELogo.png",
            "site_name" => "管理中心",
            "site_url" => Url::build(),
        ];
    }

    public function getLeftMenuData()
    {
        // TODO: Implement getLeftMenuData() method.
        return [
            ["id" => 1, "name" => "仪表盘", "url" => "http://www.baidu.com", "icon" => " fa fa-dashboard", "pid" => 0],
            ["id" => 9, "name" => "demo1", "url" => url("demo/index/demo1", ['html' => "simple"]), "icon" => " fa fa-circle-o", "pid" => 1, "badge" => "new"],
            ["id" => 2, "name" => "仪表盘1", "url" => url("demo/index/showhtml", ['html' => "simple"]), "icon" => " fa fa-circle-o", "pid" => 1, "badge" => "new"],
            ["id" => 3, "name" => "仪表盘2", "url" => url("demo/index/showhtml", ['html' => "data"]), "icon" => " fa fa-circle-o", "pid" => 1],
            ["id" => 4, "name" => "仪表盘3", "url" => "http://www.baidu.com", "icon" => " fa fa-circle-o", "pid" => 1],
            ["id" => 5, "name" => "小组件", "url" => "http://www.baidu.com", "icon" => " fa fa-th", "pid" => 0, "badge" => "hot", "badge_class" => "badge badge-info"],
            ["id" => 10, "name" => "alert", "url" => url("demo/index/showhtml", ['html' => "alert"]), "icon" => " fa fa-circle-o", "pid" => 5, "badge" => "hot", "badge_class" => "badge badge-info"],
            ["id" => 11, "name" => "confirm", "url" => url("demo/index/showhtml", ['html' => "confirm"]), "icon" => " fa fa-circle-o", "pid" => 5, "badge" => "hot", "badge_class" => "badge badge-info"],
            ["header" => 1, "title" => "其它设置", "after_id" => 5],
            ["id" => 6, "name" => "验证测试", "url" => url("demo/index/showhtml", ['html' => "validate"]), "icon" => " fa fa-circle-o text-danger", "pid" => 0],
            ["id" => 7, "name" => "关于我们", "url" => "http://www.baidu.com", "icon" => " fa fa-circle-o text-info", "pid" => 0],
            ["id" => 8, "name" => "联系我们", "url" => "http://www.baidu.com", "icon" => " fa fa-circle-o text-waring", "pid" => 0],
        ];
    }

    public function getTopRightNavs()
    {
        // TODO: Implement getTopNoticeData() method.
        return [\app\demo\controller\Notice::class,
            \app\demo\controller\Chat::class,
        ];

    }

    public function getTheme()
    {
        // TODO: Implement getTheme() method.
        //primary warning info  danger success
        return "danger";
    }

    public function getLeftMenuTheme()//dark or light
    {
        // TODO: Implement getLeftMenuTheme() method.
        return "light";
    }
}