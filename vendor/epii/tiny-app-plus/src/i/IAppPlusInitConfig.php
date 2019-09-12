<?php
namespace epii\app\i;
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/1/2
 * Time: 1:23 PM
 */
interface IAppPlusInitConfig
{
    public function get_view_engine(): string;
    public function get_cache_dir(): string;
    public function get_web_url_prefix(): string;
    public function get_view_config(): array ;
    public function get_db_config(): array ;
}