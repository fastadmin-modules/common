<?php

namespace addons\common;

use app\common\library\Menu;
use think\Addons;
use think\addons\Service;

/**
 * 插件
 */
class Common extends Addons
{

    /**
     * 插件安装方法
     * @return bool
     */
    public function install()
    {
        $menu = [[
            'name' => 'common',
            'title' => '公共管理',
            'icon' => 'fa fa-creative-commons',
            'sublist' => [
                ["name" => "common/article", "title" => "文章管理",'icon' => 'fa fa-file-text-o','ismenu'=>1],
                ["name" => "common/slide", "title" => "轮播图管理",'icon' => 'fa fa-image','ismenu'=>1],
                ["name" => "common/opinion", "title" => "意见反馈",'icon' => 'fa fa-reply-all','ismenu'=>1],
                ["name" => "common/problem", "title" => "常见问题",'icon' => 'fa fa-circle-o','ismenu'=>1],
                ["name" => "common/video", "title" => "视频管理",'icon' => 'fa fa-circle-o','ismenu'=>1],
                ["name" => "common/video_category", "title" => "视频分类管理",'icon' => 'fa fa-circle-o','ismenu'=>1],
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
        Menu::delete("common");
        Service::refresh();
        return true;
    }

    /**
     * 插件启用方法
     * @return bool
     */
    public function enable()
    {
        Menu::enable('common');
        return true;
    }

    /**
     * 插件禁用方法
     * @return bool
     */
    public function disable()
    {
        Menu::disable("common");
        return true;
    }


}
