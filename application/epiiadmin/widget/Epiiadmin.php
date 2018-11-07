<?php
namespace app\epiiadmin\widget;


/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2018/6/26
 * Time: 下午3:33
 */
class EpiiAdmin
{
    public function shownav()
    {
        $manager = app(\wslibs\i\epiiadmin\ILeftAndTopData::class);
        $navsclass = $manager->getTopRightNavs();
        $navs = "";
        foreach ($navsclass as $nav) {
            $navs .= app($nav)->getHtml();
        }
        return template_parse("epiiadmin@common/nav", ['navlist' => $navs]);

    }

    public function showleft()
    {
        $manager = app(\wslibs\i\epiiadmin\ILeftAndTopData::class);

        $siteuserinfo = $manager->getLeftTopData();

        $menu = $manager->getLeftMenuData();

        $siteuserinfo['menu'] = $menu;
        $siteuserinfo['menu_open'] = $manager->isMenuAllOpen();
        $siteuserinfo['menu_active_id'] = (int)$manager->getMenuActiveId();

        $asider = app(\wslibs\i\epiiadmin\IAsideMaker::class);

        return $asider->getAsideHtml($siteuserinfo);
    }
}