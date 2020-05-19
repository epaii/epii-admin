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
        array_unshift($roles, ["id" => "", "name" => "全部"]);
        $this->assign('roles', $roles);
        $this->adminUiDisplay('admin/index', "", ["version" => time()]);
    }

    /**
     * 表格数据
     */
    public function ajaxdata()
    {
        $map = [];

        $group_name = Args::postVal('role');
        if ($group_name) {
            $map["a.role"] = $group_name;
        }

        $name = Args::postVal('username');
        if ($name) {
            $map["a.username"] = $name;
        }

        $table = Db::name('admin')
            ->alias('a')
            ->field('a.*,r.name as rname')
            ->join('role r', 'a.role=r.id');

        echo $this->tableJsonData($table, $map, function ($data) {
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

            $id = Args::params("id/d");

            $username = trim(Args::params("username/1"));

            $password = Args::params("password" . ($id ? "" : "/1"));

            $group_name = trim(Args::params("group_name/1"));
            $status = trim(Args::params("status/1"));
            $role = trim(Args::params("role/1"));

            if (!$username || !$group_name || !$status || !$role) {
                $cmd = Alert::make()->msg('不能为空')->icon('5')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();
            }

            if (!preg_match("/^[a-zA-Z]{1}[a-zA-Z\d_]{4,19}$/", $username)) {
                $cmd = Alert::make()->icon('5')->msg('用户名格式错误')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();

            }

            if ($password)

                if (!preg_match("/^[a-zA-Z\d_]{6,16}$/", $password)) {
                    $cmd = Alert::make()->icon('5')->msg('密码6~16位')->onOk(null);
                    return JsCmd::make()->addCmd($cmd)->run();
                }


            if (!preg_match("/^[\x{4e00}-\x{9fa5}]{2,8}$/u", $group_name)) {
                $cmd = Alert::make()->icon('5')->msg('昵称为2~8个汉字')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();
            }


            $data = [];

            $data['username'] = $username;
            if ($password)
                $data['password'] = md5($password);
            $data['group_name'] = $group_name;
            $data['status'] = $status;
            $data['role'] = $role;

            $data['updatetime'] = time();

            if (!$id) {
                $has = Db::name('admin')->where('username', $username)->find();
                if ($has) {
                    $cmd = Alert::make()->msg('名字已存在')->icon('5')->onOk(null);
                    return JsCmd::make()->addCmd($cmd)->run();
                }
                $data['addtime'] = time();
                $res = Db::name('admin')->insert($data);
            } else {
                $res = Db::name('admin')->where("id", $id)->update($data);
            }


            if ($res) {

                return JsCmd::alertCloseRefresh("成功");
            } else {
                return JsCmd::alert("操作失败");
            }
            ;

        } else {
            if ($id = Args::params("id/d")) {
                $this->_as_admin = Db::name('admin')->where('id', $id)->find();
            }

            $roles = Db::name('role')->field('id,name')->select();
            $this->assign('roles', $roles);
            $this->assign("status_arr", [["value" => "nornal", "text" => "正常"], ["value" => "locked", "text" => "锁定"]]);
            $this->adminUiDisplay('admin/add');
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