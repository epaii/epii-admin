<?php

namespace epii\api\result;

/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/11/30
 * Time: 1:38 PM
 */
class ApiResult
{


    private $data = null;


    public function __construct($stringOrdata = null)
    {


        if (is_array($stringOrdata))
            $this->data = $stringOrdata;
        else if (is_string($stringOrdata)) {
            $this->data = json_decode($stringOrdata, true);

        }
        if (!$this->data) {
            $this->data = ["code" => "-1000", "msg" => "字符格式不正确", "data" => []];
        }

    }

    public function isSuccess($code_value = 1)
    {
        if (!isset($this->data["code"])) {
            return false;
        }
        return $this->data["code"] == $code_value;
    }

    public function getMsg()
    {
        return isset($this->data["msg"]) ? $this->data["msg"] : "";
    }

    public function getCode()
    {
        return isset($this->data["code"]) ? $this->data["code"] : "";
    }

    public function getData()
    {
        return isset($this->data["data"]) ? $this->data["data"] : "";
    }

    public function getDataValue($name)
    {
        if ($data = self::getData()) {
            if (is_array($data)) {
                return isset($data[$name]) ? $data[$name] : null;
            }
        }
        return null;
    }

    /*
     *
     */
    public function getApiResultData($key)
    {

        return new ApiResult($this->getData()[$key]);
    }

}