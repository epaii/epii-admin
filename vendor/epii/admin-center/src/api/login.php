<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/4/9
 * Time: 6:50 PM
 */

namespace epii\admin\center\api;


use epii\server\Args;
use epii\server\Response;
use think\Db;

class login extends api
{
    public function beforLogin()
    {

    }
    public function onLogin($user): array
    {
        return [];
    }

    public function login()
    {


        if (!Args::params("username") || !Args::params("password")) {
            Response::error("参数错误");
        }
        $this->beforLogin();

        $username = Args::params("username");


        $password = Args::params("password");


        $user = Db::name('admin')
            ->field('*')
            ->where('username', $username)
            ->find();
        if ($user) {
            if ($user['password'] == md5($password)) {


                Response::success(array_merge(["token" => $user["password"] . $user["id"], "username" => $user["username"], "show_name" => $user["group_name"]], $this->onLogin($user)));

            } else {
                $msg = '密码错误';

            }
        } else {
            $msg = '用户名不存在';

        }
        Response::error($msg);


    }
}