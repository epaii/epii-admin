
install

```json
{
    "require": {
        "epii/admin-ui-login": ">=0.0.1"
    }
}
```


```php
 AdminLogin::login(new class implements IloginConfig
        {
            public function onPost(string $username, string $password, &$msg): bool
            {

                // TODO: Implement onPost() method.
                $msg = "失败";
                return true;
            }


            public function getConfigs(): array
            {
                // TODO: Implement getConfigs() method.
                return ["success_url"=>"http://www.baidu.com"];

            }
        });

```


config支持字段 

```php
 [
        "title" => "后台登录",
        "success_url" => "",
        "bg_imgs" => [
            "http://epii.gitee.io/static/imgs/login_imgs/login1.jpg",
            "http://epii.gitee.io/static/imgs/login_imgs/login2.jpg",
            "http://epii.gitee.io/static/imgs/login_imgs/login3.jpg",
            "http://epii.gitee.io/static/imgs/login_imgs/login4.jpg"],
        "username_tip" => "用户名或电子邮件",
        "password_tip" => "密　码",
        "btn_msg"=>"登 录"

    ]
```
