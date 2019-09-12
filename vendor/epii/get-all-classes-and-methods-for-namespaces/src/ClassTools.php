<?php

namespace epii\tools\classes;

use Composer\Autoload\ClassLoader;
use ReflectionClass;


/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/1/10
 * Time: 10:00 AM
 */
class ClassTools
{
    public static function get_all_classes_and_methods(array $namespaces,bool $include_parent=false): array
    {

        if (!$namespaces) return [];

        $list = spl_autoload_functions();
        if (count($list) > 0 && ($classes = $list[0])) {
            ob_start();
            $loader = null;
            foreach ($classes as $class) {
                if ($class instanceof ClassLoader) {
                    $loader = $class;
                    break;
                }
            }
            if ($loader) {
                $path_list = $loader->getPrefixesPsr4();


                if (count($path_list) > 0) {
                    $namespace_keys = array_keys($path_list);
                    $dir_list = [];

                    foreach ($namespaces as $namespace) {

                        $namespace = rtrim($namespace, "\\")."\\";
                        foreach ($namespace_keys as $key) {

                            if (stripos($namespace, $key) === 0) {
                                $path_es = [];
                                foreach ($path_list[$key] as $path) {
                                    $path_es[] = $path . str_replace("\\", DIRECTORY_SEPARATOR, str_replace($key, DIRECTORY_SEPARATOR, $namespace));
                                }
                                $dir_list[rtrim($namespace, "\\")] = $path_es;
                            }

                        }
                    }

                    return self::getClassesAndMethodsByPath($dir_list,$include_parent);
                }

            }

            ob_end_clean();
        }
        return [];

    }

    private static function getClassesAndMethodsByPath(array $name_dir,bool $include_parent=false): array
    {


        $out = [];
        foreach ($name_dir as $name => $dirs) {
            foreach ($dirs as $dir) {


                $stacks = [$dir];
                $name_o = $name;

                while ($directory = array_shift($stacks)) {

                    if (!is_dir($directory))  continue;
                    $name_add = "";
                    if ($dir_more = str_replace($dir,"",$directory))
                    {
                        $name_add = "\\".str_replace(DIRECTORY_SEPARATOR,"\\",$dir_more);
                    }
                    $name = $name_o.$name_add;

                    $directory = rtrim($directory,DIRECTORY_SEPARATOR);

                    $mydir = opendir($directory);


                    while (($file = readdir($mydir))!==false) {


                        if ((is_dir("$directory/$file")) AND ($file != ".") AND ($file != "..")) {

                            array_push($stacks, "$directory/$file");

                        } else if (substr_compare($file, ".php", -4) === 0) {
                            $class = $name . "\\" . str_replace(".php", "", $file);


                            if (class_exists($class)) {
                                $list_tmp = (new ReflectionClass($class))->getMethods();
                                foreach ($list_tmp as $list_item)
                                {
                                    if ($include_parent || $list_item->class===$class)
                                        $out[$list_item->class][] =  $list_item->name;
                                }
                            }else{

                            }

                        }

                    }
                    closedir($mydir);
                }


            }
        }


        return $out;
    }
}