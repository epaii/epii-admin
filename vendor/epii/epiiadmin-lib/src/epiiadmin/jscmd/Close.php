<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/7/5
 * Time: 上午9:37
 */

namespace wslibs\epiiadmin\jscmd;


/**
 * @method \wslibs\epiiadmin\jscmd\CloseAndRefresh make() static
 * @method Array data()
 * @method \wslibs\epiiadmin\jscmd\CloseAndRefresh closeNum(int $num) 当前层代表0
 */

class Close extends JsCmdCommon
{
    public function init()
    {

        $this->closeNum(0);

    }
}