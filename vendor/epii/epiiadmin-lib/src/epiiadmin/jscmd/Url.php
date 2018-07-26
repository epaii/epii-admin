<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/7/5
 * Time: 上午9:37
 */

namespace wslibs\epiiadmin\jscmd;


/**
 * @method \wslibs\epiiadmin\jscmd\Url make() static
 * @method Array data()
 * @method \wslibs\epiiadmin\jscmd\Url url(string $url)
 * @method \wslibs\epiiadmin\jscmd\Url openType(string $type) dialog or addtab or _blank or location or ajax
 * @method \wslibs\epiiadmin\jscmd\Url title(string $title) dialog or addtab need
 * @method \wslibs\epiiadmin\jscmd\Url area(string $width,string $height) dialog or addtab need
 * @method \wslibs\epiiadmin\jscmd\Url intop(string $in) dialog or addtab need
 */
class Url extends JsCmdCommon
{
    public function init()
    {
        $this->openType("location")->intop(0)->title("");
    }
}