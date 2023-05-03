# fastadmin之幻灯slide插件

## 快速使用
```
cd addons &&
git clone https://github.com/sxqibo/fastadmin-addon-slide slide && 
php think addon -a slide -c package &&
cd .. &&
rm -rf addons/slide

安装时到 runtime/addons/slide-1.0.0.zip
```



## 一：把自己的写的代码做成单独包
例如：幻灯是 `slide` 我们就把文件夹改变 `slide`

## 二：增加一些配置项
1. 数据库
2. 安装卸载

## 三：用命令打包
不能直接把包右键zip，总会报错！
建议用命令
```
php think addon -a slide -c package
```
运行完命令到 `runtime/addon` 文件夹会有一个包： `slide-1.0.0.zip`

## 四：使用
后台使用 `本地上传` 使用，上传时会有一个限制，请到官方进行下载，我们需要修改一条命令：
位置： `vendor/karsonzhang/fastadmin-addons/src/addons/Service.php`

把下边这行去掉即可
```
// 压缩包验证、版本依赖判断
// Service::valid($params);
```
