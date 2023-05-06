<?php

namespace app\admin\model\common;

use think\Model;


class Video extends Model
{

    // 表名
    protected $name = 'common_video';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $deleteTime = 'delete_time';

    protected $hidden = ['update_time', 'delete_time'];

    // 追加属性
    protected $append = [
        'create_time_text',
        'update_time_text',
        'video_url',
        'image_url'
    ];

    // 地址类型
    const ADDRESS_TYPE_URL   = 1; // 网络地址
    const ADDRESS_TYPE_LOCAL = 2; // 本地上传

    public function getVideoUrlAttr($val, $row)
    {
        $type = $row['type'];
        if ($type == self::ADDRESS_TYPE_URL) {
            $fullUrl = $row['url'];
        } else {
            $fullUrl = cdnurl($row['url'], true);
        }

        return $fullUrl;
    }

    public function getImageUrlAttr($val, $row)
    {
        $value = $row['image'] ?? '';
        return !empty($value) ? cdnurl($value, true) : '';
    }

    protected static function init()
    {
        // 写入前操作
        self::beforeWrite(function ($row) {
            if (isset($row['url1']) && isset($row['url2'])) {
                if ($row['type'] == self::ADDRESS_TYPE_URL) {
                    $row['url'] = $row['url1'];
                } else {
                    $row['url'] = $row['url2'];
                }
            }
           
        });
    }

    public function category()
    {
        return $this->belongsTo(VideoCategory::class, 'category_id');
    }

    public function getCreateTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['create_time']) ? $data['create_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getUpdateTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['update_time']) ? $data['update_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getDeleteTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['delete_time']) ? $data['delete_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setCreateTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setUpdateTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setDeleteTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
