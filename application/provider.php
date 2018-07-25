<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用容器绑定定义
return [
   

    "wslibs\\i\\epiiadmin\\IAsideMaker" => wslibs\epiiadmin\EpiiAdminMenu::class,

    "wslibs\\i\\epiiadmin\\IJavaScriptArgs" => wslibs\epiiadmin\JavaScriptArgs::class,
    "js_args" => wslibs\i\epiiadmin\IJavaScriptArgs::class

];
