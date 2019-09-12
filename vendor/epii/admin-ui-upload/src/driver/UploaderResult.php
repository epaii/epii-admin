<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/2/16
 * Time: 8:51 AM
 */

namespace epii\ui\upload\driver;

class UploaderResult
{

    private $data = [];

    public function success(string $path,string $absolute_url,array $data = [])
    {
        $data["code"] = 1;
        $data["path"] = $path;
        $data["url"] = $absolute_url;
        $data["msg"] = "success";
        $data["jsonrpc"]="2.0";
        $this->data = $data;
    }

    public function error(string $msg, $code = 0)
    {
        $data = [];
        $data["code"] = $code;
        $data["msg"] = $msg;
        $data["jsonrpc"]="2.0";
        $data["error"]=["code"=> $code, "message"=>$msg];
        $this->data = $data;
    }

    public function getResult()
    {
        return $this->data;
    }
}