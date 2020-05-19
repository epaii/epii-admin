<?php

namespace epii\admin\center\libs;

use epii\orm\Db;

abstract class AddonsApp
{
    abstract public function install(): bool;
    abstract public function update($new_version, $old_version): bool;
    abstract public function onOpen(): bool;
    abstract public function onClose(): bool;
    protected $config = [];
    protected $id = 0;
    protected $info = [];
    public function setConfig($id, $config)
    {
        $this->config = $config;
        $this->id = $id;
        $this->info = Db::name("addons")->where("id", $id)->find();
    }

    protected function execSqlFile($file, $replace_prefix = "")
    {
       
       return Tools::execSqlFile($file, $replace_prefix);
    }

    protected function addMenu($pid, string $name, $url, $icon_class = "fa-circle-o", $badge_content = null, $badge_class = "badge badge-danger", $_blank = false)
    {
        $id =  Db::name("node")->insertGetId(["name" => $name, "sort" => 1, "url" => $url . "&__addons=" . $this->config["name"], "status" => 1, "icon" => " fa " . $icon_class, "pid" => $pid, "badge" => $badge_content, "badge_class" => $badge_class, "open_type" => $_blank ? 1 : 0]);
        $this->updateMenu($id);
        return $id;
    }

    protected function addMenuHeader(string $title, $icon_class = "fa-circle-o")
    {
        $id =  Db::name("node")->insertGetId(["pid" => 0, "url" => "", "status" => 1, "name" => $title, "sort" => 1, "icon" => " fa " . $icon_class]);
        $this->updateMenu($id);
        return $id;
    }

    private function updateMenu($id)
    {
        if ($id) {
            $info = Db::name("addons")->where("id", $this->id)->find();
            $has =  array_filter(explode(",", $info["menu_ids"]));
            $has[] = $id;
            $info = Db::name("addons")->where("id", $this->id)->update(["menu_ids" => implode(",", $has)]);
        }
    }
}
