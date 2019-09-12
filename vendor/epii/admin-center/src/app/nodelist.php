<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/8
 * Time: 15:13
 */

namespace epii\admin\center\app;

use app\epiiadmin\controller\EpiiController;
use epii\admin\center\common\_controller;
use epii\admin\center\config\AdminCenterUiConfig;
use epii\admin\center\config\Settings;
use epii\admin\ui\lib\epiiadmin\jscmd\Alert;
use epii\admin\ui\lib\epiiadmin\jscmd\Close;
use epii\admin\ui\lib\epiiadmin\jscmd\CloseAndRefresh;
use epii\admin\ui\lib\epiiadmin\jscmd\JsCmd;
use epii\admin\ui\lib\epiiadmin\jscmd\JsEval;
use epii\admin\ui\lib\epiiadmin\jscmd\Refresh;
use epii\server\Args;
use think\Db;
use wangshouwei\session\Session;

class nodelist extends _controller
{
    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * 菜单
     */
    public function index()
    {
        $list = Db::name("node")->where("pid =0")->select();
        $this->assign("list", $list);
        $this->adminUiDisplay('nodelist/index');
    }

    /**
     * 表格数据
     */
    public function ajaxdata()
    {

        $name = trim(Args::params("name"));
        $pid = trim(Args::params("pid"));
        $offset = trim(Args::params("offset"));
        $limit = trim(Args::params("limit"));
        $sql = "SELECT *,if(pid=0,id,pid) as pidd from ".Db::getConfig("prefix")."node order by pidd asc,pid asc,sort desc limit " . $offset . ',' . $limit;
        if (!empty($name)) {
            $sql = "SELECT *,if(pid=0,id,pid) as pidd from ".Db::getConfig("prefix")."node where name like '%" . $name . "%' order by pidd asc,pid asc,sort desc limit " . $offset . ',' . $limit;

        }
        if (!empty($pid)) {
            $sql = "SELECT *,if(pid=0,id,pid) as pidd from ".Db::getConfig("prefix")."node where  pid=" . $pid . " order by pidd asc,pid asc,sort desc limit " . $offset . ',' . $limit;

        }
        if (!empty($name) && !empty($pid)) {
            $sql = "SELECT *,if(pid=0,id,pid) as pidd from ".Db::getConfig("prefix")."node where name like '%" . $name . "%' and pid=" . $pid . "order by pidd asc,pid asc,sort desc limit " . $offset . ',' . $limit;
        }
        $data = Db::query($sql);
        foreach ($data as $k => $v) {
            if ($data[$k]['pid'] != 0) {
                $data[$k]['name'] = '------' . $v['name'];
            }

            $data[$k]['icon'] = '<i class="' . $v['icon'] . '"></i>';

        }
        $total = Db::name('node')->count('id');
        echo json_encode(['rows' => $data, 'total' => $total]);

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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim(Args::params("name"));
            $pid = trim(Args::params("pid"));
            $icon = trim(Args::params("icon"));
            $url = trim(Args::params("url"));
            $remark = trim(Args::params("remark"));
            $status = trim(Args::params("status")) ?: 0;
            $sort = trim(Args::params("sort"));

            if (!$name || !$icon) {
                $alert = Alert::make()->msg("缺少参数")->icon('5')->title("重要提示")->btn("好的");
                return JsCmd::make()->addCmd($alert)->run();
            }

            if ($pid != 0 && !$url) {
                $alert = Alert::make()->msg("URL不能是空")->icon('5')->title("重要提示")->btn("好的");
                return JsCmd::make()->addCmd($alert)->run();
            }

            if (Db::name('node')->where("name = '$name'")->find()) {
                $alert = Alert::make()->msg($name . "节点已存在")->icon('5')->title("重要提示")->btn("好的");
                return JsCmd::make()->addCmd($alert)->run();
            }

            $data['name'] = $name;
            $data['pid'] = $pid;
            $data['remark'] = $remark;
            $data['status'] = $status;
            $data['sort'] = $sort;
            $data['icon'] = $icon;

            $data['url'] =  $url;
            $data['open_type'] = (int) Args::params("open_type");
            $re = Db::name('node')
                ->insertGetId($data);

            if ($re) {
                Settings::_saveCache();
                $alert = Alert::make()->msg("操作成功")->icon('6')->onOk(CloseAndRefresh::make()->layerNum(0)->closeNum(0))->title("重要提示")->btn("好的");
            } else {
                $alert = Alert::make()->msg("操作失败，请重试")->icon('5')->title("重要提示")->btn("好的");
            }

            return JsCmd::make()->addCmd($alert)->run();

        } else {

            $list = Db::name("node")->where('pid', 0)->select();
            $this->assign("list", $list);
            $this->adminUiDisplay('nodelist/add');
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
        $id = Args::params("id");
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (!$id) {
                return JsCmd::make()->addCmd(Alert::make()->msg("缺少参数")->title("重要提示")->btn("好的"))->run();
            }

            $name = trim(Args::params("name"));
            $pid = trim(Args::params("pid"));
            $icon = trim(Args::params("icon"));
            $url = trim(Args::params("url"));
            $remark = trim(Args::params("remark"));
            $status = trim(Args::params("status")) ?: 0;
            $sort = trim(Args::params("sort"));


            if (!$name || !$icon) {
                $alert = Alert::make()->msg("缺少参数")->icon('5')->title("重要提示")->btn("好的");
                return JsCmd::make()->addCmd($alert)->run();
            }

            if ($pid != 0 && !$url) {
                $alert = Alert::make()->msg("URL不能是空")->icon('5')->title("重要提示")->btn("好的");
                return JsCmd::make()->addCmd($alert)->run();
            }

            $data['name'] = $name;
            $data['pid'] = $pid;
            $data['remark'] = $remark;
            $data['status'] = $status;
            $data['sort'] = $sort;
            $data['icon'] = $icon;
            $data['url'] = $url;

            $data['open_type'] = (int) Args::params("open_type");
            $re = Db::name("node")
                ->where("id = '$id'")
                ->update($data);


            if ($re) {
                Settings::_saveCache();
                if (Args::postVal("inhome")) {
                    $alert = Alert::make()->msg("操作成功")->icon('6')->onOk(JsEval::make()->add_string("top.window.location.reload();"))->title("重要提示")->btn("好的");
                } else {
                    $alert = Alert::make()->msg("操作成功")->icon('6')->onOk(CloseAndRefresh::make()->layerNum(0)->closeNum(0))->title("重要提示")->btn("好的");
                }


            } else {
                $alert = Alert::make()->msg("失败或未修改，请重试")->icon('5')->title("重要提示")->btn("好的");
            }
            return JsCmd::make()->addCmd($alert)->run();

        } else {

            $list = Db::name("node")->where('pid', 0)->select();
            $this->assign("list", $list);
            $this->assign("id", $id);
            $nodeinfo = Db::name("node")->where("id", $id)->find();
            $this->assign('nodeinfo', $nodeinfo);
            $this->adminUiDisplay('nodelist/edit');
        }

    }

    /**
     * @return array|false|string
     * @throws \think\Exception
     * @throws \think\db\exception\PDOException
     * 删除方法
     */
    public function del()
    {

        $id = Args::params('id');
        $res = Db::name('node')->delete($id);
        if ($res) {
            Settings::_saveCache();
            $cmd = Alert::make()->msg('删除成功')->icon('6')->onOk(Refresh::make()->type("table"));
        } else {
            $cmd = Alert::make()->msg('删除失败')->icon('5')->onOk(null);
        }
        echo JsCmd::make()->addCmd($cmd)->run();
    }

    public function icon()
    {
        $this->adminUiDisplay('nodelist/icon');
    }

    public function set_icon()
    {
        $icon=Args::params('icon');
        $this->adminUijsArgs('icon',$icon);
        echo json_encode(['icon'=>$icon]);
    }
}