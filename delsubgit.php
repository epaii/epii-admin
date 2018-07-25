<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/7/25
 * Time: 下午5:59
 */

function deldir($dir)
{
    //先删除目录下的文件：
    $dh = opendir($dir);
    while ($file = readdir($dh)) {
        if ($file != "." && $file != "..") {
            $fullpath = $dir . "/" . $file;
            if (!is_dir($fullpath)) {
                unlink($fullpath);
            } else {
                deldir($fullpath);
            }
        }
    }
    closedir($dh);

    //删除当前文件夹：
    if (rmdir($dir)) {
        return true;
    } else {
        return false;
    }
}

function delsubgit($dir)
{
    $dh = opendir($dir);
    while ($file = readdir($dh)) {
        if ($file != "." && $file != "..") {

            $fullpath = $dir . "/" . $file;
            if (is_dir($fullpath)) {


                if("./.git"!= $fullpath)
                {

                    if( strrchr($fullpath,".git")==".git" )
                    {

                        deldir($fullpath);
                    }else{
                        // echo $fullpath."\n";
                        delsubgit($fullpath);
                    }
                }


            }
        }
    }
    closedir($dh);




//删除当前文件夹：
//    if (rmdir($dir)) {
//        return true;
//    } else {
//        return false;
//    }

}
delsubgit(".");