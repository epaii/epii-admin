<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Config;

// 应用公共文件


define('WEB_DOMAIN_ROOT', "http://" . $_SERVER['HTTP_HOST']);
define('WEB_SITE_ROOT', "http://" . $_SERVER['HTTP_HOST'] . "/");
if ( \think\facade\Env::get("static_domain"))
{
    define("STATIC_URL_ROOT", \think\facade\Env::get("static_domain"));

}else{
    define("STATIC_URL_ROOT", WEB_SITE_ROOT."/epiiadmin-js");
}
define('IS_YUN', true);




if (!function_exists('template_parse')) {
    /**
     * 渲染模板输出
     * @param string $template 模板文件
     * @param array $vars 模板变量
     * @param integer $code 状态码
     * @param callable $filter 内容过滤
     * @return string
     *
     */



    function template_parse($template = '', $vars = [])
    {
        $config = Config::pull('template');
        $config['layout_on'] = false;
        $view = new \think\View();
        $view->init($config);

        return $view->assign($vars)->fetch($template);
    }
}
