
install

```json
{
    "require": {
        "epii/template-engine": ">=0.0.1"
    }
}
```


```php
require_once __DIR__ . "/vendor/autoload.php";

$config = ["tpl_dir" => __DIR__."/view","cache_dir"=>__DIR__."/cache"];

\epii\template\View::setEngine($config);



$data = ["name" => "张三", "age" => "222","key_name"=>"name1","info"=>["name1"=>"李四"],
    "list"=>[
        ["name"=>"任0"],
        ["name"=>"任1"],
        ["name"=>"任2"],
        ["name"=>"任3"]
    ]
];
\epii\template\View::display("a/index", $data);

```

其它方法

```php
View::fetch($file, $data);
View::display($file, $data);
View::fetchContent($content, $data);
View::displayContent($content, $data);


View::addCommonData(Array $data);//设置公共数据

//自定义规则
View::addStringRule($string_find, $string_replace);
View::addPregRule($preg_find, $replace_string);
View::addPregRuleCallBack($preg_find, callable $replace);

```

支持第三方引擎 

```
View::setEngine($config,支持自定义模板引擎类,默认为\epii\template\engine\EpiiViewEngine::class);
// 如果使用纯php本身语言为模板，只需使用\epii\template\engine\PhpViewEngine::class  即可
//第三方类只需实现 接口 epii\template\i\IEpiiViewEngine

```


在模板文件中 a/index.php

>  以下语法为默认模板引擎\epii\template\engine\EpiiViewEngine::class

```
{$name} ,{$info.name1},{$info.$key_name}//方法一
<?php echo $name; ?>, <?php echo $info[$key_name]; ?>//方法二
<?=$name?> ////方法三
```

函数支持

```
{$time_int|date,Y-m-d H:i:s,$0} //$0 代表当前值，逗号隔开为参数顺序
```

也可以

```
{:date,Y-m-d H:i:s,$time_int} //
```
 
函数中的参数如果有","号，用"\\,"代替

如
``` 
{:rtrim,aaa\,,\,}// 相当于 echo rtrim("aaa,",",");
```

函数中的参数如果有变量，可以直接写变量，但如果使用变量连接则用"\\{\\}"来区分变量
 
 如
 ``` 
 {:rtrim,aaa\,,$a} // 相当于 echo rtrim("aaa,",$a);
 {:rtrim,aaa\,,aa\{$a\}bb} // 相当于 echo rtrim("aaa,","aa".$a."bb");
 ```

遍历与其他

```
{loop $list}

    {$key},{$value.name}

{/loop}


{loop $list $mykey=>$myvalue}
{$mykey},{$myvalue}
{/loop}

{foreach $list}

    {$key},{$value.name}

{/foreach}


{foreach $list $mykey=>$myvalue}
{$mykey},{$myvalue}
{/foreach}


{if  $name=="aaa" }
    1111111111
{elseif $name=="cccc"}
    333333
{else}
   00000000
{/if}

```

包含其它模板文件

```
{include a/b}
{include a/b\{$a\}}
{include "a/b\{$a\}"}

```

?号语法

```
{? $a 1}  
{? $a b} 

```
相当于
``` 
<?php   echo isset($a)?$a:"1"  ?> //
<?php   echo isset($a)?$a:"b"  ?>
```

> 支持php原生所有语法

