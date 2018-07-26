<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/7/5
 *
 */

namespace wslibs\i\epiiadmin;


interface IJsCmd
{

    public function getCmdName();

    public function getArgs();
}