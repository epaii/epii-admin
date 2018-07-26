<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/7/5
 * Time: 上午9:49
 */

namespace wslibs\epiiadmin\jscmd;


use wslibs\i\epiiadmin\IJsCmd;


abstract class JsCmdCommon implements IJsCmd
{

    protected $_data = [];


    public function init()
    {
        return $this;
    }

    public function getArgs()
    {
        // TODO: Implement getArgs() method.
        $this->_data['__cmd__'] = strtolower(basename(str_replace('\\', '/', $this->getCmdName())));

        return $this->_data;
    }

    public function getCmdName()
    {
        // TODO: Implement getCmdName() method.
        return get_called_class();
    }

    public static function make()
    {
        $out = new static();
        $out->init();
        return $out;
    }

    public function setTimeout($time)
    {
        $this->_data['__time__'] = $time;
        return $this;
    }

    public function set($key, $value)
    {
        $this->_data[$key] = $value;
        return $this;
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.

        if ($name == "data") {
            if (!$arguments)
                return $this->_data;
            if (count($arguments) == 2) {
                $this->_data[$arguments[0]] = $arguments[1];
            }
        }


        if (stripos($name, "add_") === 0) {
            $name = explode("_", $name)[1] . "s";
            if (count($arguments) == 1) {
                $this->_data[$name][] = $arguments[0];
            }
            if (count($arguments) == 2) {
                $this->_data[$name][] = $arguments;
            }
            if (count($arguments) == 1 && $arguments[0] instanceof IJsCmd) {
                $this->_data[$name][] = $arguments[0]->getArgs();
            }
        } else {
            if (count($arguments) == 1 && !$arguments[0] instanceof IJsCmd) {
                $this->_data[$name] = $arguments[0];
            }
            if (count($arguments) == 1 && $arguments[0] instanceof IJsCmd) {
                $this->_data[$name] = $arguments[0]->getArgs();
            }
            if (count($arguments) == 2) {
                $this->_data[$name] = $arguments;
            }
        }

        return $this;
    }
}