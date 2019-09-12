<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/9/5
 * Time: 2:12 PM
 */

namespace epii\server\i;


interface IResponseHandler
{
    public function result($code, $msg, $data = null, $type = null, array $header = []);
}