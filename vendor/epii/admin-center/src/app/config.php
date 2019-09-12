<?php
/**
 * User: hey
 * Date: 2019/1/11
 * Time: 9:35
 */

namespace epii\admin\center\app;


use epii\admin\center\common\_controller;
use epii\admin\center\config\Settings;
use epii\admin\ui\lib\epiiadmin\jscmd\Alert;
use epii\admin\ui\lib\epiiadmin\jscmd\CloseAndRefresh;
use epii\admin\ui\lib\epiiadmin\jscmd\JsCmd;
use epii\admin\ui\lib\epiiadmin\jscmd\Refresh;
use epii\server\Args;
use think\Db;

class config extends _controller
{
    /**
     * 菜单
     */
    public function index()
    {

     $this->adminUiDisplay('config/index');
    }

    /**
     * 数据
     */
    public function ajaxdata()
    {
        echo $this->tableJsonData('setting',["uid"=>0],function($data){
           return $data;
        });
    }

    /**
     * @return array|false|string
     * 添加页面+添加
     */
    public function add(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $name = trim(Args::params("name"));
            $value= trim(Args::params("value"));
            $tip = trim(Args::params("tip"));

            if(!$name || !$value || !$tip ){
                $cmd = Alert::make()->msg('缺少参数')->icon('5')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();
            }
             $data['name']=$name;
             $data['value']=$value;
             $data['tip']=$tip;
             $data['addtime']=time();
             $res = Db::name('setting')->insert($data);

            if ($res) {
                Settings::_saveCache();
                $cmd = Alert::make()->msg('添加成功')->icon('6')->onOk(CloseAndRefresh::make()->type("table"));
            } else {
                $cmd = Alert::make()->msg('添加失败')->icon('5')->onOk(null);
            }
            return JsCmd::make()->addCmd($cmd)->run();
        }else{

            $this->adminUiDisplay('config/add');
        }
    }

    /**
     * @return array|false|string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\PDOException
     * 编辑页面+编辑
     */
    public function edit()
    {
        $id=Args::params('id');
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $name = trim(Args::params("name"));
            $value= trim(Args::params("value"));
            $tip = trim(Args::params("tip"));

            if(!$name || !$value || !$tip ){
                $cmd = Alert::make()->msg('缺少参数')->icon('5')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();
            }
            $data['name']=$name;
            $data['value']=$value;
            $data['tip']=$tip;
            $data['id']=$id;
            $res = Db::name('setting')->where("id",$id)->update($data);
            if ($res) {
                Settings::_saveCache();
                $cmd = Alert::make()->msg('修改成功')->icon('6')->onOk(CloseAndRefresh::make()->type("table"));
            } else {
                $cmd = Alert::make()->msg('修改失败')->icon('5')->onOk(null);
            }
            return JsCmd::make()->addCmd($cmd)->run();

        }else{
            $config = Db::name('setting')->where('id',$id)->find();
            $this->assign('config',$config);
            $this->assign('id',$id);
            $this->adminUiDisplay('config/edit');
        }
    }

    /**
     * @return array|false|string
     * @throws \think\Exception
     * @throws \think\db\exception\PDOException
     * 删除
     */
    public function del()
    {

        $id = Args::params('id');
        $res = Db::name('setting')->delete($id);
        if ($res) {
            Settings::_saveCache();
            $cmd = Alert::make()->msg('删除成功')->icon('6')->onOk(Refresh::make()->type("table"));
        } else {
            $cmd = Alert::make()->msg('删除失败')->icon('5')->onOk(null);
        }
        return JsCmd::make()->addCmd($cmd)->run();
    }
}