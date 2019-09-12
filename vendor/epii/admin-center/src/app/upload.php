<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/2/16
 * Time: 2:20 PM
 */

namespace epii\admin\center\app;


use epii\admin\center\common\_controller;
use epii\ui\upload\AdminUiUpload;

class upload extends _controller
{
    public function img()
    {
        echo AdminUiUpload::doUpload(["gif", "jpeg", "jpg", "png"], 2048000, pathinfo($_SERVER["SCRIPT_FILENAME"], PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . "upload", "upload/");
        exit;
    }
}