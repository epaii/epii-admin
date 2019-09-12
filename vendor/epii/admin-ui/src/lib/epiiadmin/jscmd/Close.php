<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/7/5
 * Time: 上午9:37
 */

namespace epii\admin\ui\lib\epiiadmin\jscmd;


/**
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\CloseAndRefresh make() static
 * @method Array data()
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\CloseAndRefresh closeNum(int $num) 当前层代表0
 */

class Close extends JsCmdCommon
{
    public function init()
    {

        $this->closeNum(0);

    }
}