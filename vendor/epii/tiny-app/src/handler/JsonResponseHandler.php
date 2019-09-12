<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/9/5
 * Time: 2:10 PM
 */

namespace epii\server\handler;

use epii\server\Args;
use epii\server\i\IResponseHandler;

class JsonResponseHandler implements IResponseHandler
{

    public function result($code, $msg, $data = null, $type = null, array $header = [])
    {
        $result = [
            'code' => $code,
            'msg' => $msg,
            'time' => time(),
            'data' => $data,
        ];


        $string = json_encode($result, JSON_UNESCAPED_UNICODE);
        if ($callback = Args::getVal("callback"))
            echo $callback . "(" . $string . ");";
        else {

            echo $string;
        }
    }
}