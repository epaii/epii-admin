<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/12/29
 * Time: 9:01 AM
 */

namespace epii\admin\ui\lib\epiiadmin;


class MenuConfig
{

    private $config = [];
    private $_show_id = 0;
    private $_opened_all = false;

    public function addMenu(int $id, int $pid, string $name, $url = "", $icon_class = "fa-circle-o", $badge_content = null, $badge_class = "badge badge-danger",$_blank=false)
    {

        $this->config[] = ["id" => $id, "name" => $name, "url" => $url, "icon" => " " . $icon_class, "pid" => $pid, "badge" => $badge_content, "badge_class" => $badge_class,"_blank"=>$_blank];

        return $this;
    }

    public function addMenuHeader(string $title, int $after_id = null)
    {
        $this->config[] = ["header" => 1, "title" => $title, "after_id" => $after_id === null ? $this->config[count($this->config) - 1]["id"] : $after_id];
        return $this;
    }

    public function selectId(int $id)
    {
        $this->_show_id = $id;
        return $this;
    }

    public function isAllOpen(bool $b)
    {
        $this->_opened_all = $b;
        return $this;
    }


    public function _getActiveId(): int
    {
        return $this->_show_id;
    }

    public function _isAllOpened(): bool
    {
        return $this->_opened_all;
    }


    public function getConfig()
    {
        return $this->config;
    }


}