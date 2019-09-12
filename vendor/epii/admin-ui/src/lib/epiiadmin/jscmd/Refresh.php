<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/7/5
 * Time: 上午9:37
 */

namespace epii\admin\ui\lib\epiiadmin\jscmd;


/**
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\Refresh make() static
 * @method Array data()
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\Refresh layerNum(int $num) 刷新基层，当前层代表0
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\Refresh layerStart(int $num) 刷新基层，当前层代表0
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\Refresh keyInTabsUrl(string $key)
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\Refresh type(string $type) table page both
 */

class Refresh extends JsCmdCommon
{
    public function init()
    {

        $this->layerNum(0)->keyInTabsUrl("")->type("both")->layerStart(0);

    }
}