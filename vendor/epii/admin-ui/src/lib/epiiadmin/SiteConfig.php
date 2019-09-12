<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/12/29
 * Time: 9:01 AM
 */

namespace epii\admin\ui\lib\epiiadmin;

/**
 * @method \epii\admin\ui\lib\epiiadmin\jscmd\Alert make() static
 * @method \epii\admin\ui\lib\epiiadmin\SiteConfig user_avatar(string $user_avatar_img_path)
 * @method \epii\admin\ui\lib\epiiadmin\SiteConfig user_name(string $user_name)
 * @method \epii\admin\ui\lib\epiiadmin\SiteConfig site_logo(string $site_logo)
 * @method \epii\admin\ui\lib\epiiadmin\SiteConfig site_name(string $site_name)
 * @method \epii\admin\ui\lib\epiiadmin\SiteConfig site_title(string $site_title)
 * @method \epii\admin\ui\lib\epiiadmin\SiteConfig app_theme(string $app_theme)    primary warning info  danger success
 * @method \epii\admin\ui\lib\epiiadmin\SiteConfig app_left_theme(string $site_title) dark or light
 * @method \epii\admin\ui\lib\epiiadmin\SiteConfig app_left_top_theme(string $site_title)primary warning info  danger success
 * @method \epii\admin\ui\lib\epiiadmin\SiteConfig app_left_selected_theme(string $site_title)primary warning info  danger success
 *
 */
class SiteConfig
{

    const app_theme_primary = "primary";
    const app_theme_warning = "warning";
    const app_theme_info = "info";
    const app_theme_danger= "danger";
    const app_theme_success = "success";
    const app_left_theme_dark= "dark";
    const app_left_theme_light = "light";
    private $config = [];

    public function __call($name, $arguments)
    {

        if (in_array($name, ["site_logo", "site_name"])) {
            $name = $name . "_show";
        }
        $this->config[$name] = $arguments[0];
        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }


}