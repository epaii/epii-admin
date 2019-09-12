<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/8
 * Time: 15:13
 */

namespace epii\admin\center\app;

use epii\admin\center\common\_controller;
use epii\admin\center\config\Rbac;
use epii\admin\center\config\Settings;
use epii\admin\center\libs\Tools;
use epii\admin\ui\lib\epiiadmin\jscmd\Alert;
use epii\admin\ui\lib\epiiadmin\jscmd\CloseAndRefresh;
use epii\admin\ui\lib\epiiadmin\jscmd\JsCmd;
use epii\admin\ui\lib\epiiadmin\jscmd\Refresh;
use epii\server\Args;
use epii\tools\classes\ClassTools;
use think\Db;

class rolelist extends _controller
{

    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * 菜单主页
     */
    public function index()
    {
        $list = Db::name("role")->where("status=1")->select();
        $this->assign("list", $list);
        $this->adminUiDisplay('rolelist/index');
    }

    /**
     * 表格数据
     */
    public function ajaxdata()
    {
        $name = trim(Args::params("name"));
        $map = [];
        if (!empty($name)) {
            $map[] = ["name", "LIKE", "%{$name}%"];
        }
        echo $this->tableJsonData('role', $map, function($data) {
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
            $name = trim(Args::params("name"));
            $status = trim(Args::params("status"));

            if (!$name) {
                $cmd = Alert::make()->msg('不能为空')->icon('5')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();
            }

            $data['name'] = $name;
            $data['status'] = $status;
            $res = Db::name('role')
                ->insert($data);
            if ($res) {
                Settings::_saveCache();
                $cmd = Alert::make()->msg('添加成功')->icon('6')->onOk(CloseAndRefresh::make()->type("table"));
            } else {
                $cmd = Alert::make()->msg('添加失败')->icon('5')->onOk(null);
            }
            return JsCmd::make()->addCmd($cmd)->run();

        } else {
            $nodes = Db::name('node')->field('id,name')->select();
            $this->assign('nodes', $nodes);
            $this->adminUiDisplay('rolelist/add');
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
            $name = trim(Args::params("name"));
            $status = trim(Args::params("status"));

            if (!$name) {
                $cmd = Alert::make()->msg('不能为空')->icon('5')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();
            }

            $data['name'] = $name;
            $data['status'] = $status;
            $data['id'] = $id;

            $res = Db::name('role')->update($data);

            if ($res) {
                Settings::_saveCache();
                $cmd = Alert::make()->msg('修改成功')->icon('6')->onOk(CloseAndRefresh::make()->type("table"));
            } else {
                $cmd = Alert::make()->msg('修改失败')->icon('5')->onOk(null);
            }
            return JsCmd::make()->addCmd($cmd)->run();

        } else {
            $nodes = Db::name('node')->field('id,name')->select();
            $role = Db::name('role')->where('id', $id)->find();
            $this->assign('role', $role);
            $this->assign('nodes', $nodes);
            $this->assign('id', $id);
            $this->adminUiDisplay('rolelist/edit');
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
        $admin = Db::name('admin')->where('role', $id)->find();
        if ($admin) {
            $alert = Alert::make()->msg("还有属于该角色的用户")->icon('5')->title("重要提示")->btn("好的");
            return JsCmd::make()->addCmd($alert)->run();
        }
        $res = Db::name('role')->delete($id);
        if ($res) {
            Settings::_saveCache();
            $cmd = Alert::make()->msg('删除成功')->icon('6')->onOk(Refresh::make()->type("table"));
        } else {
            $cmd = Alert::make()->msg('删除失败')->icon('5')->onOk(null);
        }
        echo JsCmd::make()->addCmd($cmd)->run();
    }


    /**
     * @return array|false|string
     * @throws \think\Exception
     * 权限控制
     */

    public function power()
    {
        $id = Args::params('id');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $type = Args::params('type');
            $power = Args::params('power');
            if (!$type) {
                $cmd = Alert::make()->msg('至少选择一种类型')->icon('5')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();
            }

            foreach ($power as $k => $v) {

                if (!$v[0]) {
                    unset($power[$k]);
                }
            }
            if (!$power) {
                $cmd = Alert::make()->msg('至少选择一个类一个方法')->icon('5')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();
            }
            $power_array = [
                'type' => $type,
                'power' => $power
            ];



            $res = Db::name('role')
                ->where('id', $id)
                ->update(['powers' => json_encode($power_array)]);
            if ($res) {
                Rbac::_saveCache();
                $cmd = Alert::make()->msg('成功')->icon('6')->onOk(CloseAndRefresh::make()->type("page"));
            } else {
                $cmd = Alert::make()->msg('失败')->icon('5')->onOk(null);
            }
            return JsCmd::make()->addCmd($cmd)->run();

        } else {
            $list = ClassTools::get_all_classes_and_methods(Tools::getEnableNameSpacePre());
            $power_array = Db::name('role')->where('id', $id)->value('powers');

            if (!$power_array) {
                $power = [];
                $type = 1;
            } else {
                $power = json_decode($power_array, true)['power'];
                foreach ($power as $k => $v) {
                    $power[$k] = array_flip($v);
                }
                $type = json_decode($power_array, true)['type'];
            }

            $this->assign('type', $type);
            $this->assign('power', $power);
            $this->assign('list', $list);
            $this->assign('id', $id);
            $this->adminUiDisplay('rolelist/power');
        }

    }

    /**
     * @return array|false|string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\PDOException
     * 导航数据
     */
    public function nav()
    {
        $id = Args::params('id');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nodes = Args::params('nodes');
            if (!$nodes[0]) {
                $cmd = Alert::make()->msg('至少选择一项')->icon('5')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();
            }
            $nodes = array_merge($nodes, Db::name("node")->whereIn("id", $nodes)->column("pid"));


            $nodes = json_encode($nodes);
            $res = Db::name('role')
                ->where('id', $id)
                ->update(['nodes' => $nodes]);
            if ($res) {

                $cmd = Alert::make()->msg('成功')->icon('6')->onOk(CloseAndRefresh::make()->type("page"));
            } else {
                $cmd = Alert::make()->msg('失败')->icon('5')->onOk(null);
            }
            return JsCmd::make()->addCmd($cmd)->run();
        } else {


            $nodes= Db::query('SELECT *,if(pid=0,id,pid) as pidd from '.Db::getConfig('prefix').'node where status=1 order by pidd asc,pid asc,sort desc');

            $node_str = Db::name('role')
                ->where('id', $id)
                ->value('nodes');
            if ($node_str) {
                $node_array = json_decode($node_str, true);
            } else {
                $node_array = [];
            }

            $this->assign('node_array', $node_array);
            $this->assign('id', $id);
            $this->assign('nodes', $nodes);
            $this->adminUiDisplay('rolelist/nav');
        }
    }
}