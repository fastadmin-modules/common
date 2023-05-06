# fastadmin之幻灯通用插件

## 快速使用
```
cd addons && 
git clone https://github.com/sxqibo/fastadmin-addon-common common &&
cd .. &&
php think addon -a common -c package &&
rm -rf addons/common
```

安装时到 runtime/addons/common-1.0.0.zip

## 一：简要介绍
在程序中一般会有常见问题，我们只需要在程序中简单显示即可！
插件包括以下内容：
* 公共管理 - 文章表
* 公共管理 - 意见反馈
* 公共管理 - 常见问题
* 公共管理 - 轮播图管理
* 公共管理 - 视频管理
* 公共管理 - 视频分类表

## 二：接口文档
待定

## 三：小程序
目录下的 `weixin` 文件夹是小程序的使用目录！
在 `app.json` 中引入文件，下边的注释是文档中所用，实际要去掉
```
{
  "pages": [
    "pages/textDetail/textDetail",
    "pages/extension/extension", // 分销页面
    "pages/extensionList/extensionList", // 分销列表（直推人数，间推人数）
    "pages/extensionInfo/extensionInfo", // 我的分销业绩
  ]
}
```



## 四：哪个项目用到模块

* 惠赚点
* 洞藏酒


## 五：相关图片
#### 公共管理 - 文章表

#### 公共管理 - 意见反馈

![列表图片](https://addons-platform.oss-cn-beijing.aliyuncs.com/modules/problems/1.png)

![修改图](https://addons-platform.oss-cn-beijing.aliyuncs.com/modules/problems/1.png)

#### 公共管理 - 常见问题

#### 公共管理 - 轮播图管理

#### 公共管理 - 视频管理

##### 公共管理 - 视频分类表


