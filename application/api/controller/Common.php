<?php

namespace app\api\controller;

use app\admin\model\common\Video;
use app\common\controller\Mini;
use app\common\exception\UploadException;
use app\common\library\Upload;
use app\common\model\Area;
use app\common\model\Config as ConfigModel;
use app\common\model\store\Store;
use app\common\model\system\NotificationConfig;
use app\common\model\Version;
use app\common\services\JwtService;
use think\Config;
use think\Hook;
use think\Log;
use think\Request;

/**
 * 公共接口
 */
class Common extends Mini
{
    protected $noNeedLogin = ['Article', 'Slide', 'Problem', 'video', 'updateVideoViewNum', 'videoCategory', 'getNoticeInfo'];

    protected $noNeedRight = '*';

    /**
     * 获取Oss获取签名信息
     */
    public function getOssParams()
    {
        $auth = new \addons\alioss\library\Auth();

        $name   = $this->request->post('name');
        $md5    = get32UUID();
        $params = $auth->params($name, $md5);

        $params['OSSAccessKeyId']        = $params['id'];
        $params['success_action_status'] = 200;
        $params['OSSAddress']            = get_addon_config('alioss')['cdnurl'];

        $this->success('成功', $params);
    }

    /**
     * 上传文件
     * @ApiMethod (POST)
     * @param File $file 文件流
     */
    public function upload()
    {
        Config::set('default_return_type', 'json');
        //必须设定cdnurl为空,否则cdnurl函数计算错误
        Config::set('upload.cdnurl', '');
        $chunkid = $this->request->post("chunkid");
        if ($chunkid) {
            if (!Config::get('upload.chunking')) {
                $this->error(__('Chunk file disabled'));
            }
            $action     = $this->request->post("action");
            $chunkindex = $this->request->post("chunkindex/d");
            $chunkcount = $this->request->post("chunkcount/d");
            $filename   = $this->request->post("filename");
            $method     = $this->request->method(true);
            if ($action == 'merge') {
                $attachment = null;
                //合并分片文件
                try {
                    $upload     = new Upload();
                    $attachment = $upload->merge($chunkid, $chunkcount, $filename);
                } catch (UploadException $e) {
                    $this->error($e->getMessage());
                }
                $this->success(__('Uploaded successful'), ['url' => $attachment->url, 'fullurl' => cdnurl($attachment->url, true)]);
            } else if ($method == 'clean') {
                //删除冗余的分片文件
                try {
                    $upload = new Upload();
                    $upload->clean($chunkid);
                } catch (UploadException $e) {
                    $this->error($e->getMessage());
                }
                $this->success();
            } else {
                //上传分片文件
                //默认普通上传文件
                $file = $this->request->file('file');
                try {
                    $upload = new Upload($file);
                    $upload->chunk($chunkid, $chunkindex, $chunkcount);
                } catch (UploadException $e) {
                    $this->error($e->getMessage());
                }
                $this->success();
            }
        } else {
            $attachment = null;
            //默认普通上传文件
            $file = $this->request->file('file');
            try {
                $upload     = new Upload($file);
                $attachment = $upload->upload();
            } catch (UploadException $e) {
                $this->error($e->getMessage());
            }

            $this->success(__('Uploaded successful'), ['url' => $attachment->url, 'fullurl' => cdnurl($attachment->url, true)]);
        }
    }

    /**
     * 获取文章详情
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function Article()
    {
        $params = request()->get();
        $name   = $params['name'];

        if (!empty($name)) {
            $Article = new \app\common\model\common\Article();
            $article = $Article->where(['name' => $name])->find();
            $article->hidden(['delete_time', 'update_time']);

            $this->success('获取文章详情成功！', $article);
        }

        $this->error('获取文章详情失败！');
    }

    /**
     * 获取文章详情
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function Problem()
    {

        $problem     = new \app\common\model\common\Problem();
        $problemList = $problem->select();
        foreach ($problemList as $row) {
            $row->hidden(['delete_time', 'update_time']);
        }
        $this->success('获取常见问题成功！', $problemList);

    }

    /**
     * 获取轮播图
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function Slide()
    {
        $Slide = new \app\common\model\common\Slide();
        $slide = $Slide->where(['status' => 1])->order(['weigh' => 'desc', 'id' => 'desc'])->select();
        foreach ($slide as $row) {
            $row->hidden(['delete_time', 'update_time', 'weigh', 'status']);
        }
        $this->success('获取轮播图成功！', $slide);
    }

    /**
     * 意见反馈
     */
    public function Option()
    {
        $params = request()->post();
        $user   = $this->auth->getUser();
        $data   = ['user_id' => $user->id];

        $data['images']  = isset($params['images']) ? $params['images'] : '';
        $data['content'] = isset($params['content']) ? $params['content'] : '';
        if ($data['images'] || $data['content']) {
            $Opinion = new \app\common\model\common\Opinion();
            $res     = $Opinion->save($data);
            if ($res) {
                $this->success('反馈成功！');
            }
        }
        $this->error('反馈失败！');
    }

    /**
     * 获取可用的消息模板
     *
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getNewsAvailability()
    {
        $params = $this->request->param();
        $type   = $params['type'] ?? '';

        if (!$type) {
            $this->error('请传入有效的参数');
        }

        $query = NotificationConfig::where('status', 1);
        switch ($type) {
            case 'normal_order';
                $query->whereIn('event', [NotificationConfig::NOTIFY_EVENT_ORDER_SENDED]);
                break;
            case 'groupon_order':
                $query->whereIn('event', [
                    NotificationConfig::NOTIFY_EVENT_ORDER_SENDED,
                    NotificationConfig::NOTIFY_EVENT_GROUPON_SUCCESS,
                    NotificationConfig::NOTIFY_EVENT_GROUPON_FAIL,
                ]);
                break;
            case 'wallet_apply':
                $query->whereIn('event', [
                    NotificationConfig::NOTIFY_EVENT_WALLET_APPLY,
                ]);
        }

        $list = $query->select();

        $newList = [];
        foreach ($list as $item) {
            $newList[] = $item['content']['template_id'];
        }
        $this->success('成功', $newList);
    }

    /**
     * 关于我们
     * @author liqiangbiao 2020/3/10 10:17
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\DataNotFoundException
     */
    public function getAboutData()
    {
        $name = $this->request->post('name');
        $data = (new ConfigModel())->getAdminConfigInfo($name);
        !empty($data) ? $this->success('数据加载成功!', $data) : $this->error('数据加载失败!');
    }

    public function test()
    {
        $userId = $this->request->param('user_id');
        //创建token
        $jwtService = new JwtService();
        $token      = $jwtService->createToken(['user_id' => $userId, 'nickname' => 'lizhongyang']);
        dd($token);
    }

    /**
     * 获取门店信息
     * @param $id
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function storeInfo(Request $request)
    {
        $mobile = $request->param('mobile', '');

        if (!$mobile) {
            $this->error('请传入有效的参数');
        }

        $storeInfo = Store::where('phone', $mobile)
            ->field('id,name,avatar,user_id,status,phone')->find();
        $this->success('成功', $storeInfo);
    }

    /**
     * 视频列表
     * @param Request $request
     * @throws \think\exception\DbException
     */
    public function video(Request $request)
    {
        $limit      = $request->param('limit', 10);
        $categoryId = $request->param('category_id', '');
        $query      = Video::with('category')->where('status', 1);

        $categoryId && $query->where('category_id', $categoryId);
        $list = $query->paginate($limit);

        foreach ($list as $item) {
            $category            = $item->category;
            $item->category_name = $category->name ?? '';
            $item->visible(['id', 'video_url', 'title', 'view_num', 'intro', 'image_url', 'category_id', 'category_name']);
        }

        $this->success('成功', $list);
    }

    /**
     * 更新视频访问次数
     * @param Request $request
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function updateVideoViewNum(Request $request)
    {
        $videoId = $request->param('video_id', '');
        if (!$videoId) {
            $this->error('请传入有效的参数');
        }
        $video = Video::where('id', $videoId)->find();
        $video->setInc('view_num', 1);

        $this->success('成功');
    }

    /**
     * 视频分类列表
     *
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function videoCategory()
    {
        $list = \app\admin\model\common\VideoCategory::where('status', 1)->select();

        foreach ($list as $item) {
            $item->visible(['id', 'name', 'desc']);
        }

        $this->success('成功', $list);
    }

    /**
     * 获取公告信息
     */
    public function getNoticeInfo()
    {
        $site = Config::get('site');
        $this->success('成功', ['switch' => (int)$site['notice_switch'], 'content' => $site['notice_content']]);
    }
}
