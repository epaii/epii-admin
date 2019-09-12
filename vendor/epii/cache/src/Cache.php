<?php
namespace epii\cache;
class Cache
{

    private static $_dir;

    public static function initDir($dir)
    {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        self::$_dir = $dir;
    }

    private static function getfile($keyword)
    {
        if (!self::$_dir) {
            self::$_dir = __DIR__ . "/../cache";
        }
        $dir = self::$_dir . "/" . substr($keyword, 0, 1) . "/" . substr($keyword, 1, 1) . "/" . substr($keyword, 2, 1);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, TRUE);
        }
        return $dir . "/" . $keyword . ".cache";
    }

    public static function setCache($keyword, $String)
    {
        $cahcefile = self::getfile($keyword);

        if (is_file($cahcefile)) {
            @unlink($cahcefile);
        }

        file_put_contents($cahcefile, $String);

    }

    public static function getCache($keyword, $time = 51840000)
    {
        $cahcefile = self::getfile($keyword);

        if (file_exists($cahcefile) && (time() - filemtime($cahcefile) < $time)) {
            return file_get_contents($cahcefile);
        } else {
            return null;
        }
    }

    public static function getCacheForever($keyword)
    {
        $cahcefile = self::getfile($keyword);

        if (file_exists($cahcefile)) {
            return file_get_contents($cahcefile);
        } else {
            return null;
        }
    }


}

?>