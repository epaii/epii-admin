<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/7/23
 * Time: 下午2:12
 */

namespace wslibs\epiiadmin\jscmd;
/**
 * @method \wslibs\epiiadmin\jscmd\CloseAndRefresh make() static
 * @method Array data()
 * @method \wslibs\epiiadmin\jscmd\CloseAndRefresh closeNum(int $num) 当前层代表0
 * @method \wslibs\epiiadmin\jscmd\CloseAndRefresh layerNum(int $num) 刷新基层，当前层代表0
 * @method \wslibs\epiiadmin\jscmd\CloseAndRefresh layerStart(int $num) 刷新基层，当前层代表0
 * @method \wslibs\epiiadmin\jscmd\CloseAndRefresh keyInTabsUrl(string $key)
 * @method \wslibs\epiiadmin\jscmd\CloseAndRefresh type(string $type) table page both
 */

class CloseAndRefresh extends JsCmdCommon
{
    public function init()
    {

        $this->closeNum(0)->layerNum(1)->keyInTabsUrl("")->type("both")->layerStart(0);;

    }
}