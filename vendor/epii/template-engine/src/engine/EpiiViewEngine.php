<?php

namespace epii\template\engine;

use epii\template\i\IEpiiViewEngine;
use epii\template\View;


/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/12/25
 * Time: 1:19 PM
 */
class EpiiViewEngine implements IEpiiViewEngine
{
    private static $view_parse = [];

    public static function addParser(string $tag_name, callable $begine_parser, callable $end_parser = null)
    {
        self::$view_parse[$tag_name] = [$begine_parser, $end_parser];
    }

    private static $view_fun = [];

    public static function addFunction(string $tag_name, callable $do)
    {
        self::$view_fun[$tag_name] = $do;
    }

    private $config = [];

    public function init(Array $config)
    {
        // TODO: Implement init() method.

        $this->config = $config;
        $this->config["tpl_dir"] = rtrim($this->config["tpl_dir"], DIRECTORY_SEPARATOR);

        if (!is_dir($this->config["cache_dir"])) {
            mkdir($this->config["cache_dir"], 0777, true);
        }

        if (!isset($this->config["tpl_begin"])) {
            $this->config["tpl_begin"] = "\\{";
        }
        if (!isset($this->config["tpl_end"])) {
            $this->config["tpl_end"] = "\\}";
        }

        self::addFunction("options", function ($list, $select_value = null) {


            if (is_array($list)) {
                $out = "";
                foreach ($list as $key => $value) {
                    if (!is_array($value)) {
                        $select = "";
                        // var_dump($args);
                        if ($select_value !== null && $key == $select_value  ) {
                            $select = "selected";
                        }
                        $out .= "<option value='" . $key . "' {$select}>" . $value . "</option>";
                    } else {
                        $_v = $key;
                        if (isset($value["id"])) {
                            $_v = $value["id"];
                        }
                        if (isset($value["value"])) {
                            $_v = $value["value"];
                        }
                        $_name = "";
                        if (isset($value["name"])) {
                            $_name = $value["name"];
                        }
                        if (isset($value["text"])) {
                            $_name = $value["text"];
                        }
                        $select = "";
                        // var_dump($args);
                        if (($select_value !== null && $_v == $select_value) || (isset($value["selected"]) && $value["selected"])) {
                            $select = "selected";
                        }
                        $out .= "<option value='" . $_v . "' " . $select . ">" . $_name . "</option>";

                    }
                }
            }

            return $out;
        });


    }


    public function fetch(string $file, Array $args = null)
    {
        $tmpfile = $this->config["tpl_dir"] . DIRECTORY_SEPARATOR . $file . ".php";

        if (!file_exists($tmpfile)) {
            $tmpfile = $this->config["tpl_dir"] . DIRECTORY_SEPARATOR . $file . ".html";
        }

        if (!file_exists($tmpfile)) {
            return "";
        } else {
            ob_start();
            if ($args !== null)
                extract($args);
            $__in_epii_view_engine = 1;
            include_once $this->get_compile_file($tmpfile);
            $content = ob_get_contents();
            ob_clean();
            return $content;
        }


    }


    private function get_compile_file(string $tmpfile)
    {

        if (isset($this->config["just_php"]) && $this->config["just_php"]) {
            return $tmpfile;
        }
        $compile_file = $this->config["cache_dir"] . DIRECTORY_SEPARATOR . md5($tmpfile) . ".php";
        if (file_exists($compile_file) && (filemtime($compile_file) > filemtime($tmpfile))) {

        } else {
            $this->parse_tpl($tmpfile, $compile_file);

        }
        return $compile_file;
    }


    private function stringToPhpData(string $string)
    {


        $string = trim($string);
        $string = trim($string, ";");

        $tmep_arr = explode("|", $string);
        $string = $tmep_arr[0];
        if (isset($tmep_arr[1])) {
            $function = $tmep_arr[1];
        } else {
            $function = null;
        }


        $array = explode(".", $string);

        $outstring = null;


        foreach ($array as $value) {
            if (stripos($value, "\$") === 0) {
                if ($outstring === null)
                    $outstring = $value;
                else
                    $outstring .= "[" . $value . "]";
            } else {


                if (stripos($value, '($') !== false) {

                    $value = preg_replace_callback('/\(\$(.*?)\)/is', function ($m) {
                        return "\".\${$m[1]}.\"";
                    }, $value);


                }

                if ($outstring === null)
                    $outstring = "\"" . $value . "\"";
                else
                    $outstring .= "[\"" . $value . "\"]";
            }
        }
        if ($outstring === null)
            $outstring = "";
        if ($function) {

            $function = str_replace("\\,", "__dou__", $function);

            $function_array = explode(",", $function);

            $function = $function_array[0];
            unset($function_array[0]);
            if (!$function_array)
                $function_array = ["\$0"];
            foreach ($function_array as $key => $value) {
                $function_array[$key] = $this->stringToPhpData($value);
            }
            if (isset(self::$view_fun[$function])) {
                $function = "self::\$view_fun[\"{$function}\"]";
            }
            $function = ($function) . "(" . implode(",", $function_array) . ")";
            $function = str_replace("__dou__", ",", $function);
            $outstring = str_replace("\$0", $outstring, $function);
        }

        return $outstring;
    }

    private function stringToYuFaStart($fun_name, $arg_string)
    {

        $arg_string = trim($arg_string);
        $args = array_filter(explode(" ", $arg_string), function ($item) {
            return $item !== "";
        });


        if ($fun_name == "loop" || $fun_name == "foreach") {
            if (!isset($args[1])) {
                $args[1] = "\$key=>\$value";
            }
            if (strtolower($args[1]) == "as") {
                if (!isset($args[2])) {
                    $args[2] = "\$key=>\$value";
                }
                $args[1] = $args[2];

            }

            return "foreach({$args[0]} as {$args[1]}):";
        } else if ($fun_name == "if" || $fun_name == "else" || $fun_name == "elseif") {
            return "$fun_name({$arg_string}):";
        } else if ($fun_name == "echo") {
            return "$fun_name \"" . str_replace("\"", "\\\"", $args[0]) . "\";";
        } else if ($fun_name == "print" || $fun_name == "dump" || $fun_name == "print_r") {
            return "print_r({$args[0]}); ";

        } else if ($fun_name == "include" || $fun_name == "include_file") {


            if (isset($args[0])) {



//                if ((stripos($args[0], "\"") !== 0) && stripos($args[0], "\'") !== 0) {
//                    $args[0] = "\"{$args[0]}\"";
//                }
                $args[0] =  str_replace(["\"","\'"],["",""],$args[0]);

                $file_pre  = $this->config["tpl_dir"] . '/' . $args[0] ;
//                if (!file_exists($file)) {
//                    $file = $this->config["tpl_dir"] . '/' . $args[0] ;
//                }

                return " \$___file_pre_= \"".$file_pre."\"; if(!file_exists(\$__file_ = \$___file_pre_.\".php\")) \$__file_= \$___file_pre_.\".html\"; include \$this->get_compile_file(\$__file_); ";

            }
        } else if ($fun_name == "?") {
            array_walk($args, function (&$value) {
                $value = $this->stringToPhpData($value);
            });
            return "echo isset(" . $args[0] . ")?" . $args[0] . ":" . (isset($args[1]) ? $args[1] : "\"\";");
        } else if (in_array($fun_name, array_keys(self::$view_parse))) {

            $args = $this->attrParse($args);
            return "echo \"" . str_replace("\"", "\\\"", call_user_func(self::$view_parse[$fun_name][0], $args)) . "\";";

        } else if (function_exists($fun_name)) {
            return "$fun_name({$args[0]}); ";
        }
        return "";
    }


    private function attrParse(array $args)
    {
        $new = [];
        foreach ($args as $key => $value) {
            $value = str_replace("\\=", "__denghao__", $value);
            if (stripos($value, "=") > 0) {
                unset($args[$key]);
                list($name, $v) = explode("=", $value);
                $new[$name] = str_replace("__denghao__", "=", $v);;
            } else {
                $args[$key] = str_replace("__denghao__", "=", $value);
            }
        }

        $i = 0;
        foreach ($args as $value) {
            $new[$i++] = $value;
        }
        return $new;


    }


    private function stringToYuFaEnd($fun_name)
    {

        if ($fun_name == "/loop" || $fun_name == "/foreach") {

            return "endforeach;";
        } else if ($fun_name == "/if") {
            return "endif;";
        } else if ($fun_name == "else") {
            return "else:";
        } else if (in_array($fun_name = substr($fun_name, 1), array_keys(self::$view_parse)) && (self::$view_parse[$fun_name][1] !== null)) {
            return call_user_func(self::$view_parse[$fun_name][1], null);
        }
        return "";
    }


    private function parse_tpl(string $tmpfile, string $compile_file)
    {
        if (!is_file($tmpfile)) {

            return false;
        }

        $txt = $this->compileString(file_get_contents($tmpfile));


        if (!is_dir($todir = dirname($compile_file))) {
            mkdir($todir, 0777, true);
        }

        $txt = "<?php if(!isset(\$__in_epii_view_engine)){exit;} ?>" . $txt;

        if (file_put_contents($compile_file, $txt)) {
            return $compile_file;

        } else {
            return false;

        }


    }

    public static function require_config_keys()
    {
        return ["tpl_dir", "cache_dir"];
    }

    public function compileString(string $txt)
    {
        $txt = str_replace("\\{", "__da_kuo_hao_start__", $txt);
        $txt = str_replace("\\}", "__da_kuo_hao_end__", $txt);

        $txt = preg_replace_callback("/" . $this->config["tpl_begin"] . "\\$(.*?)" . $this->config["tpl_end"] . "/is", function ($match) {
            $string = $this->stringToPhpData("\$" . $match[1]);
            return "<?php echo $string; ?>";
        }, $txt);
        $txt = preg_replace_callback("/" . $this->config["tpl_begin"] . ":(.*?)" . $this->config["tpl_end"] . "/is", function ($match) {
            $string = $this->stringToPhpData("|" . $match[1]);
            return "<?php echo $string; ?>";
        }, $txt);


        $txt = preg_replace_callback("/" . $this->config["tpl_begin"] . "([^" . $this->config["tpl_begin"] . "]*?)" . $this->config["tpl_end"] . "/is", function ($match1) {

            if (stripos($match1[1], " ") === 0) {
                return $match1[0];
            }
            $match1[1] = rtrim(trim($match1[1]), ";");

            if (($pox = stripos($match1[1], " ")) > 0) {
                $string = $this->stringToYuFaStart(substr($match1[1], 0, $pox), substr($match1[1], $pox));
            } else {
                $string = $this->stringToYuFaEnd($match1[1]);
            }

            if ($string === "") {
                return $match1[0];
            }

            return "<?php   $string  ?>";
        }, $txt);

        $txt = str_replace("__da_kuo_hao_start__", "{", $txt);
        $txt = str_replace("__da_kuo_hao_end__", "}", $txt);
        return $txt;
    }

    public function parseString(string $string, Array $args = null)
    {
        ob_start();
        if ($args !== null)
            extract($args);

        eval('?> ' . $this->compileString($string) . ' <?php ');

        $content = ob_get_contents();
        ob_clean();
        return $content;
    }
}
