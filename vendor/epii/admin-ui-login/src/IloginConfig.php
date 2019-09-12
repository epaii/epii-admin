<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/2/19
 * Time: 1:49 PM
 */

namespace epii\ui\login;


interface IloginConfig
{
    public function onPost(string $username, string $password, &$msg): bool;

    public function getConfigs(): array;

}