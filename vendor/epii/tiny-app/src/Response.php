<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/11/8
 * Time: 2:14 PM
 */

namespace epii\server;


use epii\server\handler\JsonResponseHandler;
use epii\server\i\IResponseHandler;

class Response
{


    /**
     * @var IResponseHandler
     */
    private static $responseHandler = null;

    public static function getResponseHandler(): IResponseHandler
    {
        if (self::$responseHandler === null) {
            self::$responseHandler = new JsonResponseHandler();
        }
        return self::$responseHandler;
    }

    /**
     * 操作成功返回的数据
     * @param string $msg 提示信息
     * @param mixed $data 要返回的数据
     * @param int $code 错误码，默认为1
     * @param string $type 输出类型
     * @param array $header 发送的 Header 信息
     */
    public static function success($data = null, $msg = '', $code = 1, $type = null, array $header = [])
    {
        if (is_string($data)) {
            $msg_tmp = $msg;
            $msg = $data;
            $data = is_array($msg_tmp) ? $msg_tmp : null;
        }
        if (!$msg) {
            $msg = "成功";
        }
        self::result($msg, $data, $code, $type, $header);
    }

    /**
     * 操作失败返回的数据
     * @param string $msg 提示信息
     * @param mixed $data 要返回的数据
     * @param int $code 错误码，默认为0
     * @param string $type 输出类型
     * @param array $header 发送的 Header 信息
     */
    public static function error($msg = '', $data = null, $code = 0, $type = null, array $header = [])
    {
        self::result($msg, $data, $code, $type, $header);
    }


    public static function createResult($code, $msg, $data = null)
    {
        $result = [
            'code' => $code,
            'msg' => $msg,
            'time' => time(),
            'data' => $data,
        ];

        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }


    private static function result($msg, $data = null, $code = 0, $type = null, array $header = [])
    {

        self::getResponseHandler()->result($code, $msg, $data, $type, $header);
        exit;


    }

    public static function show($msg)
    {
        // TODO: Implement show() method.
        echo $msg;
    }

    public static function exit($msg)
    {
        // TODO: Implement exit() method.
        self::show($msg);
        exit;
    }

    /**
     * @param IResponseHandler $responseHandler
     */
    public static function setResponseHandler(IResponseHandler $responseHandler)
    {
        self::$responseHandler = $responseHandler;
    }


}