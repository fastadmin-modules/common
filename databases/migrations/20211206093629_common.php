<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Common extends Migrator
{
    public function change()
    {
        // 常见问题表
        $table = $this->table('common_problem');
        $table->addColumn(Column::string('title')->setDefault('')->setComment('问题名称'))
            ->addColumn(Column::text('description')->setComment('问题内容'))
            ->addColumn(Column::integer('create_time')->setComment('添加时间'))
            ->addColumn(Column::integer('update_time')->setComment('修改时间'))
            ->addColumn(Column::integer('delete_time')->setComment('删除时间')->setNullable())
            ->create();

        \think\Db::execute('alter table `fzw_common_problem` comment "公共管理 - 常见问题"');

        // 视频管理表
        $table = $this->table('common_video');
        $table
            ->addColumn(Column::integer('category_id')->setDefault(0)->setComment('分类ID'))
            ->addColumn(Column::string('title')->setDefault('')->setComment('标题'))
            ->addColumn(Column::string('image')->setDefault('')->setComment('封面图'))
            ->addColumn(Column::tinyInteger('type')->setDefault(1)->setComment('地址类型：1=url 2=本地上传 3=云文件'))
            ->addColumn(Column::string('url')->setDefault('')->setComment('网络地址'))
            ->addColumn(Column::integer('view_num')->setComment('观看次数'))
            ->addColumn(Column::string('intro')->setDefault('')->setComment('介绍'))
            ->addColumn(Column::text('desc')->setDefault('')->setComment('视频详细介绍'))
            ->addColumn(Column::tinyInteger('status')->setDefault(1)->setComment('状态：1=显示 0=隐藏'))
            ->addColumn(Column::string('file_name')->setDefault('')->setComment('视频上传名'))
            ->addColumn(Column::string('file_size')->setDefault('')->setComment('视频上传大小'))
            ->addColumn(Column::integer('creator_id')->setDefault(0)->setComment('创建者ID'))

            // 时间相关
            ->addColumn(Column::integer('create_time')->setComment('添加时间'))
            ->addColumn(Column::integer('update_time')->setComment('修改时间'))
            ->addColumn(Column::integer('delete_time')->setComment('删除时间')->setNullable())

            ->addIndex('category_id')
            ->create();

        \think\Db::execute('alter table `fzw_common_video` comment "公共-视频管理"');

        // 视频管理表
        $table = $this->table('common_video_category');
        $table->addColumn(Column::string('name')->setDefault('')->setComment('标题'))
            ->addColumn(Column::integer('pid')->setDefault(0)->setComment('父ID'))
            ->addColumn(Column::text('desc')->setDefault('')->setComment('介绍'))
            ->addColumn(Column::tinyInteger('status')->setDefault(1)->setComment('状态：1=显示 0=隐藏'))

            // 时间相关
            ->addColumn(Column::integer('create_time')->setComment('添加时间'))
            ->addColumn(Column::integer('update_time')->setComment('修改时间'))
            ->addColumn(Column::integer('delete_time')->setComment('删除时间')->setNullable())
            ->create();

        \think\Db::execute('alter table `fzw_common_video_category` comment "公共-视频分类表"');


    }
}
