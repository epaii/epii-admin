<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/2/15
 * Time: 6:09 PM
 */

namespace epii\ui\upload\driver;

interface IUploader
{
    public function handlePostFiles(array $allowedExts=["gif", "jpeg", "jpg", "png"],$file_size=204800,$dir=null,$url_pre = null):UploaderResult;
    public function del(array $data):bool ;
}
