<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/7/23
 * Time: 下午2:12
 */

namespace epii\admin\ui\lib\epiiadmin\jscmd;
/**
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\CloseAndRefresh make() static
 * @method Array data()
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\CloseAndRefresh closeNum(int $num) 当前层代表0
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\CloseAndRefresh layerNum(int $num) 刷新基层，当前层代表0
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\CloseAndRefresh layerStart(int $num) 刷新基层，当前层代表0
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\CloseAndRefresh keyInTabsUrl(string $key)
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\CloseAndRefresh type(string $type) table page both
 */

class CloseAndRefresh extends JsCmdCommon
{
    public function init()
    {

        $this->closeNum(0)->layerNum(1)->keyInTabsUrl("")->type("both")->layerStart(0);;

    }
}