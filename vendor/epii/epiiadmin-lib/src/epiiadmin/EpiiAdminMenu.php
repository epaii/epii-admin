<?php
namespace wslibs\epiiadmin;

use wslibs\i\epiiadmin\IAsideMaker;
use wslibs\traits\singleton;

/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/6/27
 * Time: 下午2:12
 */
class EpiiAdminMenu implements IAsideMaker
{

    use singleton;
    public static $debug = true;

    private $_as = array();
    private $_menu = array();

    private $_pidname = "pid";
    private $_menu_open = false;


    public function addMenu($id, $name, $url, $icon, $pid = 0, $badge_string = null, $badge_class = "badge badge-danger")
    {

        if ($badge_class == null) {
            $badge_class = "badge badge-danger";
        }
        $this->_menu[$id] = array("m_code" => "_code_" . $id, "id" => $id, "title" => $name, "url" => $url, "icon" => $icon, "pid" => $pid, "p_code" => "_code_" . $pid);


        $badge_string && ($this->_menu[$id]['badge'] = '<span class="right ' . $badge_class . '">' . $badge_string . '</span>');

        return $this;
    }


    public function addHeader($afterid, $title)
    {
        $this->_menu[$afterid]['after_header'] = '<li class="nav-header">' . $title . '</li>';
    }


    public function getMenu($select_id)
    {


        $menu = $this->getTreeMenu(0, '<li class="nav-item@class"><a href="@url@addtabs" @addtab data-url="@url"      data-title="@title"  class="nav-link@aclass"><i class="nav-icon @icon"></i> <p>@title@caret@badge</p></a> @childlist</li>@after_header', [$select_id, $this->_menu[$select_id]['pid']], '', 'ul', 'class="nav nav-treeview"');


        return $menu;
    }

    public function setDefualtPageId($id)
    {
        $this->_as['click_url_mod'] = "_code_" . $id;
    }

    public function getChild($myid)
    {

        $newarr = [];
        foreach ($this->_menu as $value) {
            if (!isset($value['id']))
                continue;
            if ($value[$this->_pidname] == $myid)
                $newarr[$value['id']] = $value;
        }

        return $newarr;
    }

    /**
     * 菜单数据
     * @param int $myid
     * @param string $itemtpl
     * @param mixed $selectedids
     * @param mixed $disabledids
     * @param string $wraptag
     * @param string $wrapattr
     * @param int $deeplevel
     * @return string
     */
    private function getTreeMenu($myid, $itemtpl, $selectedids = '', $disabledids = '', $wraptag = 'ul', $wrapattr = '', $deeplevel = 0)
    {

        $str = '';
        $childs = $this->getChild($myid);
        if ($childs) {
            foreach ($childs as $value) {
                $id = $value['id'];
                unset($value['child']);
                $selected = in_array($id, (is_array($selectedids) ? $selectedids : explode(',', $selectedids))) ? 'selected' : '';
                $disabled = in_array($id, (is_array($disabledids) ? $disabledids : explode(',', $disabledids))) ? 'disabled' : '';
                $value = array_merge($value, array('selected' => $selected, 'disabled' => $disabled));
                $value = array_combine(array_map(function ($k) {
                    return '@' . $k;
                }, array_keys($value)), $value);
                $bakvalue = array_intersect_key($value, array_flip(['@url', '@caret', '@class']));
                $value = array_diff_key($value, $bakvalue);
                $nstr = strtr($itemtpl, $value);
                $value = array_merge($value, $bakvalue);
                $childdata = $this->getTreeMenu($id, $itemtpl, $selectedids, $disabledids, $wraptag, $wrapattr, $deeplevel + 1);
                $childlist = $childdata ? "<{$wraptag} {$wrapattr}>" . $childdata . "</{$wraptag}>" : "";
                $childlist = strtr($childlist, array('@class' => $childdata ? 'last' : ''));
                $value = array(
                    '@childlist' => $childlist,
                    '@url' => $childdata || !isset($value['@url']) ? "#" : $value['@url'],
                    '@addtabs' => $childdata || !isset($value['@url']) ? "" : (stripos($value['@url'], "?") !== false ? "&" : "?") . "ref=addtabs&_code_id=" . $id,
                    '@caret' => ($childdata && (!isset($value['@badge']) || !$value['@badge']) ? '<i class="right fa fa-angle-left"></i>' : ''),
                    '@badge' => isset($value['@badge']) ? $value['@badge'] : '',
                    '@class' => ($disabled ? ' disabled' : '') . ($childdata ? ' has-treeview' . ($selected || $this->_menu_open ? ' menu-open' : '') : ''),
                    '@aclass' => (!$childdata && $selected ? ' active' : ''),
                    '@addtab_id' => $childdata ? 0 : $value['@id'],
                    '@after_header' => isset($value['@after_header']) ? $value['@after_header'] : '',
                    '@addtab' => $childdata ? "" : 'data-addtab="tab_' . $value['@id'] . '"'

                );

                $str .= strtr($nstr, $value);
            }
        }
        return $str;
    }


    public function getAsideHtml($data)
    {
        // TODO: Implement getAsideHtml() method.
        array_map(function ($value) {
            if (isset($value['header'])) {
                $this->addHeader($value['after_id'], $value['title']);
            } else
                $this->addMenu($value['id'], $value['name'], $value['url'], $value['icon'], $value['pid'], isset($value['badge']) ? $value['badge'] : null, isset($value['badge_class']) ? $value['badge_class'] : null);
        }, $data['menu']);

        $this->_menu_open = $data['menu_open'];
        $data['menulist'] = $this->getMenu($data['menu_active_id']);



        return template_parse("epiiadmin@common/menu", $data);
    }
}