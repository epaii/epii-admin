<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/4/9
 * Time: 6:44 PM
 */

namespace epii\admin\center\api;

use epii\server\Args;
use epii\server\Response;
use think\Db;

class api extends \epii\server\api
{

    protected $uid = 0;
    protected $username = 0;
    protected $user = null;

    /**
     * @return bool
     */
    protected function doAuth(): bool
    {

        // TODO: Implement doAuth() method.

        if (!($token = trim(Args::params("token")))) {
            Response::error("需要授权");
        }
        $p = substr($token, 0, 32);
        $id = substr($token, 32);

        $user = Db::name('admin')
            ->field('*')
            ->where('id', $id)
            ->where("password", $p)
            ->find();
        if (!$user) {
            Response::error("授权失败");
        }
        $this->uid = $user["id"];
        $this->user = $user;
        $this->username = $user["username"];

        return true;
    }


}