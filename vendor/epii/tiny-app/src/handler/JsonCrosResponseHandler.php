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

class JsonCrosResponseHandler extends JsonResponseHandler
{

    public function result($code, $msg, $data = null, $type = null, array $header = [])
    {
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Credentials:true');
        parent::result($code, $msg, $data, $type, $header);
    }
}
