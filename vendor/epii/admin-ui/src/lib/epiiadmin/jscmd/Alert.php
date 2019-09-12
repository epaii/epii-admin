<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/7/5
 * Time: 上午9:37
 */

namespace epii\admin\ui\lib\epiiadmin\jscmd;


/**
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\Alert make() static
 * @method Array data()
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\Alert title(string $name)
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\Alert msg(string $msg)
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\Alert onOk(\epii\admin\ui\lib\i\epiiadmin\IJsCmd $cmd)
 */
class Alert extends JsCmdCommon
{
    public function init()
    {
        $this->msg("操作成功")->title("提醒")->onOk(Refresh::make());
    }
}