<?php
namespace app\demo\controller;


use app\epiiadmin\controller\EpiiController;
use wslibs\epiiadmin\jscmd\Alert;
use wslibs\epiiadmin\jscmd\CloseAndRefresh;
use wslibs\epiiadmin\jscmd\JsCmd;
use wslibs\epiiadmin\jscmd\JsEval;
use wslibs\epiiadmin\jscmd\Refresh;
use wslibs\epiiadmin\jscmd\Url;

class Index extends EpiiController
{
    public function index()
    {
        $this->jsAppName("demo/a");

        return $this->showTopWindow(new \app\demo\model\Epiiadmin());
    }


    public function demo1()
    {
        return $this->fetch("demo/demo1");
    }

    public function showhtml($html)
    {
//        if ($html == "validate") {
//            $this->jsAppName("demo/" . $html);
//        }



        $this->jsArgs("ddd", "aaaa");
        if ($this->request->isAjax()) {
            sleep(10);
            return ['click' => 1, "test"];
        }

        return $this->fetch("demo/" . $html);
    }

    public function formajax()
    {
        return JsCmd::make()->addCmd(Alert::make()->msg("提交成功"))->run();
    }


    public function ajaxdata()
    {

        return json(["rows" => [
            ["id" => 1, "name" => "张三", "price" => "nicasq"],
            ["id" => 2, "name" => "张三", "price" => "nicasq"],
            ["id" => 3, "name" => "张三", "price" => "nicasq", "price_class" => "badge badge-info", "price_style" => ["background-color" => "red"]],
            ["id" => 9, "name" => "张三", "price" => "nicasq"],
            ["id" => 4, "name" => "张三", 'name_style' => ["color" => "red", "background-color" => "blue"], "price" => "nicasq"],

            ["id" => 5, "name" => "张三", "price" => "nicasq", 'name_color' => "red"],
            ["id" => 7, "name" => "张三", "price" => "nicasq"],
        ], "total" => 100]);
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }

    public function ajaxdel()
    {
        return JsCmd::make()->addCmd(Alert::make())->addCmd(JsEval::make()->add_string("alert(1);")->setTimeout(3000));

    }

    public function ajax_del()
    {
        $cmd = Alert::make()->msg("操作成功")->onOk(Refresh::make()->type("table"));

        return JsCmd::make()->addCmd($cmd)->run();

    }

    public function r()
    {
        //return JsCmd::make()->addCmd(Alert::make()->onOk(Refresh::make()->layerNum(2))->title("百度"))->run();
        return JsCmd::make()->addCmd(Alert::make()->onOk(CloseAndRefresh::make()->closeNum(0)->layerNum(0))->title("百度"))->run();

    }

    public function del()
    {
        // $this->success("asdfasdf","asfdsd",['a'=>1,"b"=>2]);
        return JsCmd::make()->addCmd(Alert::make()->onOk(Url::make()->url(url("demo/index/showhtml/", ["html" => "test1"]))->intop(1)->openType("dialog")->title("百度")))->addCmd(JsEval::make()->add_string("alert(1);")->setTimeout(3000)->add_function("myalert", ["asdfasdfasdf"]))->run();

    }

    public function details()
    {
        print_r($_GET);
    }

    public function arr()
    {
        return json([["text"=>"aaa","id"=>"1"],["text"=>"bbb","id"=>"2"],["text"=>"ccc","id"=>"3"]]);
    }

}
