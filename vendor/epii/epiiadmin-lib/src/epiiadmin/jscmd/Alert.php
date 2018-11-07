<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/7/5
 * Time: 上午9:37
 */

namespace wslibs\epiiadmin\jscmd;


/**
 * @method \wslibs\epiiadmin\jscmd\Alert make() static
 * @method Array data()
 * @method \wslibs\epiiadmin\jscmd\Alert title(string $name)
 * @method \wslibs\epiiadmin\jscmd\Alert msg(string $msg)
 * @method \wslibs\epiiadmin\jscmd\Alert onOk(\wslibs\i\epiiadmin\IJsCmd $cmd)
 */
class Alert extends JsCmdCommon
{
    public function init()
    {
        $this->msg("操作成功")->title("提醒")->onOk(Refresh::make());
    }
}