<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/9/23
 * Time: 5:07 PM
 */

namespace epii\admin\center;


use epii\orm\Db;
use epii\server\Response;
use epii\server\Tools;

class Api extends \epii\server\App
{
    public function __construct($configOrFilePath = null)
    {

        parent::__construct($configOrFilePath);
        $this->init(function () {
            if (file_exists($db_config = Tools::getVendorDir() . "/../config/db.conf.php")) {

                Db::setConfig(include $db_config);
            } else {
                Response::error($db_config . " is not find!");
            }

        });


    }
}