<?php

namespace epii\ui\upload;

use epii\admin\ui\EpiiAdminUi;

use epii\ui\upload\driver\IUploader;
use epii\ui\upload\driver\LocalFileUploader;
use epii\ui\upload\driver\UploaderResult;

/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/1/8
 * Time: 1:09 PM
 */
class AdminUiUpload
{

    private static $handler_class;

    public static function init(string $upload_url,string $class = LocalFileUploader::class)
    {
        EpiiAdminUi::addPluginData("upload_url", $upload_url);
        self::$handler_class = $class;

    }


    public static function setUploadHandler(string $class)
    {
        self::$handler_class = $class;
    }


    private static function getUploadHandler(): IUploader
    {
        if (!self::$handler_class) {
            self::$handler_class = new LocalFileUploader();
        } else {
            if (is_string(self::$handler_class)) {
                self::$handler_class = new self::$handler_class();
            }
        }

        if (!(self::$handler_class instanceof IUploader)) {
            echo "Uploader Must instanceof IUploader ";
            exit;
        }
        return self::$handler_class;

    }

    public static function doUpload(array $allowedExts = ["gif", "jpeg", "jpg", "png"], $file_size = 204800, $dir = null, $url_pre = null): string
    {
        // die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
        return json_encode(self::getUploadHandler()->handlePostFiles( $allowedExts , $file_size , $dir , $url_pre )->getResult(), true);


    }

    public static function delFile(array $data): string
    {
        // die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
        // TODO: Implement del() method.
        $ret = new UploaderResult();


        $out = self::getUploadHandler()->del($data);
        if ($out) {
            $ret->success("","");
        } else {
            $ret->error("");
        }
        return json_encode($ret->getResult(), true);


    }


}
