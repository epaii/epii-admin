<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/7/5
 * Time: 上午11:09
 */

namespace wslibs\epiiadmin\jscmd;


use wslibs\i\epiiadmin\IJsCmd;

class JsCmd
{










    private static $_return_string = true;

    public static function returnData( $is_data)
    {
        self::$_return_string = !$is_data;
    }

    private $cmds = [];


    public static function make()
    {
        return new self();
    }


    public function addCmd(IJsCmd $cmd)
    {
        $this->cmds[] = $cmd->getArgs();
        return $this;
    }

    public function run()
    {
        if (self::$_return_string)
            return json(['code' => 1, "msg" => "", "data" => $this->getCmdData()]);
        else return $this->getCmdData();
    }

    public function getCmdData()
    {
        return ["epii_eval" => 1, "cmds" => $this->cmds];
    }

    public static function alertRefresh($msg = "操作成功", $layerNum = 0)
    {
        return self::make()->addCmd(Alert::make()->msg($msg)->onOk(Refresh::make()->layerNum($layerNum)))->run();
    }

    public static function alertCloseRefresh($msg = "操作成功", $closeNum = 0, $layerNum = 0)
    {
        return self::make()->addCmd(Alert::make()->msg($msg)->onOk(CloseAndRefresh::make()->closeNum($closeNum)->layerNum($layerNum)))->run();
    }

    public static function alertUrl($url, $msg = "操作成功", $openType = "location")
    {
        return self::make()->addCmd(Alert::make()->msg($msg)->onOk(Url::make()->url($url)->openType($openType)))->run();

    }

    public static function toastCloseRefresh($msg = "操作成功", $closeNum = 0, $layerNum = 0)
    {
        return self::make()->addCmd(Toast::make()->msg($msg)->onFinish(CloseAndRefresh::make()->closeNum($closeNum)->layerNum($layerNum)))->run();
    }

    public static function toastRefresh($msg = "操作成功", $layerNum = 0)
    {
        return self::make()->addCmd(Toast::make()->msg($msg)->onFinish(Refresh::make()->layerNum($layerNum)))->run();
    }

    public static function toastUrl($url, $msg = "操作成功", $openType = "location")
    {
        return self::make()->addCmd(Toast::make()->msg($msg)->onFinish(Url::make()->url($url)->openType($openType)))->run();
    }

    public static function url($url, $openType = "location")
    {
        return self::make()->addCmd(Url::make()->url($url)->openType($openType))->run();
    }

}