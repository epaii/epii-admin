<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/2/16
 * Time: 9:05 AM
 */

namespace epii\ui\upload\driver;


class LocalFileUploader implements IUploader
{

    private static $dir = "";
    private static $url_pre = "";

    public static function init(string $upload_dir, string $url_pre)
    {
        self::$dir = rtrim($upload_dir, DIRECTORY_SEPARATOR);
        self::$url_pre = rtrim($url_pre, "/") . "/";
    }

    public static function getInitUploadDir()
    {
        if (!self::$dir) {
            self::$dir = pathinfo($_SERVER["SCRIPT_FILENAME"], PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . "upload";
        }
        return self::$dir;
    }

    public static function getInitUploadUrlPre()
    {
        if (!self::$url_pre) {
            self::$url_pre = "upload/";
        }
        return self::$url_pre;
    }

    public function handlePostFiles(array $allowedExts = ["gif", "jpeg", "jpg", "png"], $file_size = 204800, $dir = null, $url_pre = null): UploaderResult
    {

        $ret = new UploaderResult();


        if (count($_FILES) == 0) {

        } else {

            if (!$dir) {
                $dir = self::getInitUploadDir();
            } else {
                $dir = rtrim($dir, DIRECTORY_SEPARATOR);
            }
            if (!$url_pre) {
                $url_pre = self::getInitUploadUrlPre();
            } else {
                $url_pre = rtrim($url_pre, "/") . "/";
            }


            if (!$dir) {
                $ret->error("请设置uploadDir,EpiiUploader::setUploadDir()");
                return $ret;
            } else {
                if (!is_dir($dir)) {
                    if (!mkdir($dir, 0777, true)) {
                        $ret->error("目录无权限");
                        return $ret;
                    }
                }
            }

            $dir = $dir . DIRECTORY_SEPARATOR . ($short_dir = date("Ym") . DIRECTORY_SEPARATOR . date("d"));
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }


            $paths = [];
            $url = [];
            foreach ($_FILES as $key => $file) {


                $temp = explode(".", $file["name"]);

                $extension = end($temp);     // 获取文件后缀名
                if (($file["size"] < $file_size) && in_array(strtolower($extension), $allowedExts)) {
                    if ($file["error"] > 0) {

                        $ret->error($file["error"]);
                        break;
                    } else {

                        $to_file_name = $dir . DIRECTORY_SEPARATOR . ($short_file = time() . rand(100, 1000) . "." . $extension);
                        if (file_exists($to_file_name)) {
                            $ret->error("目标文件已经存在");
                            break;
                        } else {
                            // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
                            move_uploaded_file($file["tmp_name"], $to_file_name);
                            $paths[] = $short_file_url = $short_dir . DIRECTORY_SEPARATOR . $short_file;
                            $url[] = str_replace("\\", "/", $url_pre . $short_file_url);


                        }
                    }
                } else {
                    $ret->error("格式或大小不符合");
                    break;
                }

            }
            if (count($paths) > 0) {
                $ret->success(implode(",", $paths), implode(",", $url));
            } else {
                $ret->error("格式或大小不符合");
            }


        }


        return $ret;
    }

    public function del(array $data): bool
    {
        return true;
    }
}