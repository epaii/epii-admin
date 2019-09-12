<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/7/5
 * Time: 上午9:37
 */

namespace epii\admin\ui\lib\epiiadmin\jscmd;


/**
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\Url make() static
 * @method Array data()
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\Url url(string $url)
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\Url openType(string $type) dialog or addtab or _blank or location or ajax
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\Url title(string $title) dialog or addtab need
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\Url area(string $width,string $height) dialog or addtab need
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\Url intop(string $in) dialog or addtab need
 */
class Url extends JsCmdCommon
{
    public function init()
    {
        $this->openType("location")->intop(0)->title("");
    }
}