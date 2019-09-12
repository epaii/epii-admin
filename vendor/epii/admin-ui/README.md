# EpiiAdminUi

```
 EpiiAdminUi::showTopPage(new DemoUi());
EpiiAdminUi::showPage($content);
```
 
 ```
   $config = [
  
          "static_url_pre" => "https://epii.gitee.io/epiiadmin-js/",
          "fontawesome_fonts_url_pre" => "https://epaii.github.io/epii-admin-static/js/plugins/font-awesome/fonts",
          "js_app_dir" => "static/js/app/",
          "site_url" => "",
          "version" => "0.0.2",
          "require_config_file" => "",
          "css" => []
  
      ];
    EpiiAdminUi::setBaseConfig(Array $config);

    EpiiAdminUi::addPluginData("skin_save_api", "http://www.baidu.com/?type={type}&value={value}");
    
    EpiiAdminUi::addPluginData(string $key, string $value)
```
