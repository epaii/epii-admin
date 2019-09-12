<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/9/5
 * Time: 4:06 PM
 */

namespace epii\app\handler;

use epii\admin\ui\lib\epiiadmin\jscmd\Alert;
use epii\admin\ui\lib\epiiadmin\jscmd\JsCmd;
use epii\server\handler\JsonResponseHandler;


class JsCmdResponseHandler extends JsonResponseHandler
{

    public function result($code, $msg, $data = null, $type = null, array $header = [])
    {
        // TODO: Implement result() method.
        if (!$code) {
            echo JsCmd::make()->addCmd(Alert::make()->msg($msg)->onOk(null))->run();
            exit;
        }
        parent::result($code, $msg, $data, $type, $header);
    }
}