<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/7/5
 * Time: 上午9:37
 */

namespace epii\admin\ui\lib\epiiadmin\jscmd;


/**
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\JsEval make() static
 * @method Array data()
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\JsEval add_string(string $eval_string)
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\JsEval add_function(string $fun_name, Array $args = [])
 */
class JsEval extends JsCmdCommon
{
    public function reload_menu_badge($menu_id = "")
    {
        return $this->add_string("window.EpiiAdmin.reload_menu_badge('" . $menu_id . "');");
    }
}