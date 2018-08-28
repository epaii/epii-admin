<?php
/**
 * FormBuilder表单生成器
 * Author: xaboy
 * Github: https://github.com/xaboy/form-builder
 */

namespace FormBuilder\traits\form;


use FormBuilder\components\Switches;

trait FormSwitchesTrait
{
    public static function switches($field, $title, $value = '0')
    {
        return new Switches($field, $title, $value);
    }
}