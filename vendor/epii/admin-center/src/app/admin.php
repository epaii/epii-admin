<?php
/**
 * User: hey
 * Date: 2019/1/9
 * Time: 16:56
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

class admin extends _controller
{
    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * 菜单
     */
    public function index()
    {
        $roles = Db::name('role')->field('id,name')->select();
        array_unshift($roles,["id"=>"","name"=>"全部"]);
        $this->assign('roles', $roles);
        $this->adminUiDisplay('admin/index',"",["version"=>time()]);
    }

    /**
     * 表格数据
     */
    public function ajaxdata()
    {
        $map = [];

        $group_name = Args::postVal('role');
        if($group_name){
            $map["a.role"]=$group_name;
        }

        $name = Args::postVal('username');
        if($name){
            $map["a.username"]=$name;
        }

        $table = Db::name('admin')
            ->alias('a')
            ->field('a.*,r.name as rname')
            ->join('role r', 'a.role=r.id');

        echo $this->tableJsonData($table, $map, function($data) {
            $data['addtime'] = date('Y-m-d H:i:s', $data['addtime']);
            $data['updatetime'] = date('Y-m-d H:i:s', $data['updatetime']);
            $data['status'] = $data['status'] == 'normal' ? "1" : "0";
            return $data;
        });
    }

    /**
     * @return array|false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * 添加页面+添加
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $username = trim(Args::params("username"));
            $password = Args::params("password");
            $group_name = trim(Args::params("group_name"));
            $status = trim(Args::params("status"));
            $role = trim(Args::params("role"));

            if (!$username || !$group_name || !$status || !$role) {
                $cmd = Alert::make()->msg('不能为空')->icon('5')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();
            }

            if(!preg_match("/^[a-zA-Z]{1}[a-zA-Z\d_]{4,19}$/",$username)){
                $cmd = Alert::make()->icon('5')->msg('用户名格式错误')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();

            }

            if (!preg_match("/^[a-zA-Z\d_]{6,16}$/", $password)) {
                $cmd = Alert::make()->icon('5')->msg('密码6~16位')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();
            }

            if (!preg_match("/^[\x{4e00}-\x{9fa5}]{2,8}$/u", $group_name)) {
                $cmd = Alert::make()->icon('5')->msg('昵称为2~8个汉字')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();
            }

            $has = Db::name('admin')->where('username', $username)->find();
            if ($has) {
                $cmd = Alert::make()->msg('名字已存在')->icon('5')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();
            }
            $data['username'] = $username;
            $data['password'] = md5($password);
            $data['group_name'] = $group_name;
            $data['status'] = $status;
            $data['role'] = $role;
            $data['addtime'] = time();
            $data['updatetime'] = time();

            $res = Db::name('admin')->insert($data);

            if ($res) {
                Settings::_saveCache();
                $cmd = Alert::make()->msg('添加成功')->icon('6')->onOk(CloseAndRefresh::make()->type("table"));
            } else {
                $cmd = Alert::make()->msg('添加失败')->icon('5')->onOk(null);
            }
            return JsCmd::make()->addCmd($cmd)->run();

        } else {
            $roles = Db::name('role')->field('id,name')->select();
            $this->assign('roles', $roles);
            $this->adminUiDisplay('admin/add');
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
        $id = trim(Args::params("id"));
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim(Args::params("username"));
            $password = Args::params("password");
            $group_name = trim(Args::params("group_name"));
            $status = trim(Args::params("status"));
            $role = trim(Args::params("role"));

            if (!$username || !$group_name || !$status || !$role) {
                $cmd = Alert::make()->msg('不能为空')->icon('5')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();
            }

            if(!preg_match("/^[a-zA-Z]{1}[a-zA-Z\d_]{4,19}$/",$username)){
                $cmd = Alert::make()->icon('5')->msg('用户名格式错误')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();

            }

            if (!preg_match("/^[\x{4e00}-\x{9fa5}]{2,8}$/u", $group_name)) {
                $cmd = Alert::make()->icon('5')->msg('昵称为2~8个汉字')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();
            }

            $has = Db::name('admin')->where('id','<>',$id)->where('username', $username)->find();
            if ($has) {
                $cmd = Alert::make()->msg('名字已存在')->icon('5')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();
            }
            $data['username'] = $username;
            $data['group_name'] = $group_name;
            $data['status'] = $status;
            $data['role'] = $role;
            $data['updatetime'] = time();
            $data['id']=$id;
            if ($password) {
                if (!preg_match("/^[a-zA-Z\d_]{6,16}$/", $password)) {
                    $cmd = Alert::make()->icon('5')->msg('密码6~16位')->onOk(null);
                    return JsCmd::make()->addCmd($cmd)->run();
                }
                $data['password'] = md5($password);
            }
            $res = Db::name('admin')->update($data);

            if ($res) {
                Settings::_saveCache();
                $cmd = Alert::make()->msg('修改成功')->icon('6')->onOk(CloseAndRefresh::make()->type("table"));
            } else {
                $cmd = Alert::make()->msg('修改失败')->icon('5')->onOk(null);
            }
            return JsCmd::make()->addCmd($cmd)->run();

        } else {
            $admin = Db::name('admin')->where('id', $id)->find();
            $roles = Db::name('role')->field('id,name')->select();
            $this->assign('id', $id);
            $this->assign('admin', $admin);
            $this->assign('roles', $roles);
            $this->adminUiDisplay('admin/edit');
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
        $res = Db::name('admin')->delete($id);
        if ($res) {
            Settings::_saveCache();
            $cmd = Alert::make()->msg('删除成功')->icon('6')->onOk(Refresh::make()->type("table"));
        } else {
            $cmd = Alert::make()->msg('删除失败')->icon('5')->onOk(Refresh::make()->type("table"));
        }
        return JsCmd::make()->addCmd($cmd)->run();
    }

}