<?php
/**
 * FormBuilder表单生成器
 * Author: xaboy
 * Github: https://github.com/xaboy/form-builder
 */

namespace FormBuilder\components;


use FormBuilder\FormComponentDriver;
use FormBuilder\Helper;
use FormBuilder\traits\component\ComponentOptionsTrait;

/**
 * 单选框组件
 * Class Radio
 * @package FormBuilder\components
 * @method $this size(String $size) 单选框的尺寸，可选值为 large、small、default 或者不设置
 * @method $this vertical(Boolean $bool) 是否垂直排列，按钮样式下无效
 */
class Radio extends FormComponentDriver
{
    use ComponentOptionsTrait;

    protected $name = 'radio';

    protected static $propsRule = [
        'size' => 'string',
        'vertical' => 'boolean'
    ];

    public function button()
    {
        $this->props['type'] = 'button';
        return $this;
    }

    public function required($message = null, $trigger = 'change')
    {
        $this->setRequired(Helper::getVar($message, '请选择' . $this->title), $trigger);
        return $this;
    }

    public function build()
    {
        $options = [];
        foreach ($this->options as $option) {
            if ($option instanceof Option)
                $options[] = $option->build();
        }
        return [
            'type' => $this->name,
            'field' => $this->field,
            'title' => $this->title,
            'value' => $this->value,
            'props' => (object)$this->props,
            'options' => $options,
            'validate' => $this->validate
        ];
    }
}