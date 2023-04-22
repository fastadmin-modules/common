<?php

namespace addons\slide;

use app\common\library\Menu;
use think\Addons;
use think\addons\Service;

/**
 * 插件
 */
class Slide extends Addons
{

    /**
     * 插件安装方法
     * @return bool
     */
    public function install()
    {
        $menu = [[
            'name' => 'common/slide',
            'title' => '轮播图管理',
            'icon' => 'fa fa-ravelry',
            'sublist' => [
                ["name" => "common/slide/index", "title" => "查看"],
                ["name" => "common/slide/recyclebin", "title" => "回收站"],
                ["name" => "common/slide/add", "title" => "添加"],
                ["name" => "common/slide/edit", "title" => "编辑"],
                ["name" => "common/slide/del", "title" => "删除"],
                ["name" => "common/slide/destroy", "title" => "真实删除"],
            ]
        ]];
        Menu::create($menu);
        Service::refresh();
        return true;
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {
        Menu::delete("slide");
        Service::refresh();
        return true;
    }

    /**
     * 插件启用方法
     * @return bool
     */
    public function enable()
    {
        Menu::enable('slide');
        return true;
    }

    /**
     * 插件禁用方法
     * @return bool
     */
    public function disable()
    {
        Menu::disable("slide");
        return true;
    }


}
