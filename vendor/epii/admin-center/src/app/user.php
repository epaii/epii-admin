<?php
/**
 * User: hey
 * Date: 2019/1/10
 * Time: 8:57
 */

namespace epii\admin\center\app;


use epii\admin\center\common\_controller;
use epii\admin\ui\demo\DemoUi;
use epii\admin\ui\lib\epiiadmin\jscmd\Alert;
use epii\admin\ui\lib\epiiadmin\jscmd\CloseAndRefresh;
use epii\admin\ui\lib\epiiadmin\jscmd\JsCmd;
use epii\admin\ui\lib\epiiadmin\jscmd\JsEval;
use epii\admin\ui\lib\epiiadmin\jscmd\Refresh;
use epii\admin\ui\lib\epiiadmin\jscmd\Url;
use epii\server\Args;
use epii\tools\classes\ClassTools;
use think\Db;
use wangshouwei\session\Session;

class user extends _controller
{
    /**
     * 退出
     */
    public function logout()
    {

        Session::empty();
        header('location:' . $_SERVER['HTTP_REFERER']);
    }

    /**
     * 修改资料页面
     */
    public function modify()
    {
            $user = Db::name('admin')->where('id', Session::get('user_id'))->find();
            $this->assign('user', $user);
            $this->adminUiDisplay('user/modify');

    }

    /**
     * @return array|false|string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\PDOException
     * 修改资料
     */
    public function modify_info(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){

            $username = Args::params('username');
            $group_name = Args::params('group_name');
            $phone = Args::params('phone');
            $email = Args::params('email');

            if (!$username || !$group_name || !$phone || !$email) {
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

            if (!preg_match('/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/', $email)) {
                $cmd = Alert::make()->icon('5')->msg('请输入正确的邮箱')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();
            }

            if (!preg_match('/^1[3456789]\d{9}$/', $phone)) {
                $cmd = Alert::make()->icon('5')->msg('请输入正确的手机号')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();
            }

            $data['id'] = Session::get('user_id');
            $data['username'] = $username;
            $data['group_name'] = $group_name;
            $data['phone'] = $phone;
            $data['email'] = $email;
            $res = Db::name('admin')->update($data);

            if ($res) {
                $cmd = Alert::make()->msg('成功')->icon('6')->onOk(CloseAndRefresh::make()->type("page"));
            } else {
                $cmd = Alert::make()->msg('失败')->icon('5')->onOk(null);
            }
            return JsCmd::make()->addCmd($cmd)->run();

        }else{

            $user = Db::name('admin')->where('id', Session::get('user_id'))->find();
            $this->assign('user', $user);
            $this->adminUiDisplay('user/modify_info');
        }
    }

    /**
     * @return array|false|string
     * @throws \think\Exception
     * 修改密码
     */
    public function modify_pwd(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){

            $user_id = Session::get('user_id');
            $old_password = md5(Args::params('old_password'));
            $new_password = Args::params('new_password');
            $re_password =Args::params('re_password');
            $password = Db::name('admin')->where('id', $user_id)->value('password');

            if (!$user_id) {
                $cmd = Alert::make()->icon('5')->msg('登陆信息过期,请退出重新登陆')->onOk(Refresh::make());
                return JsCmd::make()->addCmd($cmd)->run();
            }

            if ($old_password != $password) {
                $cmd = Alert::make()->icon('5')->msg('原密码不正确')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();
            }

            if ($new_password != $re_password) {
                $cmd = Alert::make()->icon('5')->msg('两次密码输入不一致')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();
            }

            if (!preg_match("/^[a-zA-Z\d_]{6,16}$/", $new_password)) {
                $cmd = Alert::make()->icon('5')->msg('密码6~16位')->onOk(null);
                return JsCmd::make()->addCmd($cmd)->run();
            }

            $res = Db::name('admin')
                ->where('id', $user_id)
                ->setField('password', md5($new_password));
            if ($res) {
                Session::del('is_login');
                $cmd = Alert::make()->msg('修改成功,重新登陆生效')->icon('6')->onOk(JsEval::make()->add_string('to_login();'));

            } else {
                $cmd = Alert::make()->msg('修改失败')->icon('5')->onOk(null);
            }
            return JsCmd::make()->addCmd($cmd)->run();


        }else{

            $this->adminUiDisplay('user/modify_pwd');
        }
    }

    /**
     * 上传头像
     */
    public function modify_photo(){
            $this->adminUiDisplay('user/modify_photo');
    }
//保存头像路径
    public function upload_path()
    {

        $path = Args::params('path');
        $path = '/upload/'.str_replace('\\','/',$path);
        $id =Session::get('user_id');
        $res = Db::name('admin')->where('id', $id)->setField('photo', $path);

        if ($res) {
            $cmd = Alert::make()->msg('修改成功')->icon('6')->onOk(CloseAndRefresh::make());
        } else {
            $cmd = Alert::make()->msg('修改失败')->icon('5')->onOk(null);
        }
        return JsCmd::make()->addCmd($cmd)->run();

    }
}