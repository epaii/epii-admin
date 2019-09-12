<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/7/5
 *
 */

namespace epii\admin\ui\lib\i\epiiadmin;


interface IJsCmd
{

    public function getCmdName();

    public function getArgs();
}