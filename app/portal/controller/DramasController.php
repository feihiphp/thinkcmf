<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 老猫 <thinkcmf@126.com>
// +----------------------------------------------------------------------
namespace app\portal\controller;

use cmf\controller\HomeBaseController;
use app\portal\model\PortalCategoryModel;
use app\portal\model\PortalDramasModel;
use app\portal\model\PortalSeedModel;
use app\portal\model\PortalPostModel;
use think\Db;

class DramasController extends HomeBaseController
{
    //获取剧集的列表。
    public function index()
    {

        $param = $this->request->param();
        $keyword = isset($param['keyword']) ? $param['keyword'] : '';
        $isMovie = isset($param['is_movie']) ? $param['is_movie'] : 0;
        if ($isMovie !=0){
            $isMovie =1;
        }

        // 查询状态为1的用户数据 并且每页显示10条数据
        $portalDramasModel = new PortalDramasModel();
        if (empty($keyword)){
            $list = $portalDramasModel->where('status',1)->where('is_movie',$isMovie)->paginate(1);
        }else{
            $list = $portalDramasModel->where('status',1)->where('is_movie',$isMovie)->where('title','like','%'.$keyword.'%')->paginate(1);
        }
        // 把分页数据赋值给模板变量list
        $this->assign('list', $list);


        $this->assign('keyword', $keyword);

        $this->assign('list', $list);
        $this->assign('page', $list->render());

        return $this->fetch(":dramas");
    }

    //最新的。按更新时间排序。
    public function lastupdate(){
        $param = $this->request->param();
        $keyword = isset($param['keyword']) ? $param['keyword'] : '';

        // 查询状态为1的用户数据 并且每页显示10条数据
        $portalDramasModel = new PortalDramasModel();
        if (empty($keyword)){
            $list = $portalDramasModel->where('status',1)->order('gmt_modified desc')->paginate(1);
        }else{
            $list = $portalDramasModel->where('status',1)->order('gmt_modified desc')->where('title','like','%'.$keyword.'%')->paginate(1);
        }
        // 把分页数据赋值给模板变量list
        $this->assign('list', $list);


        $this->assign('keyword', $keyword);

        $this->assign('list', $list);
        $this->assign('page', $list->render());

        return $this->fetch(":dramas");
    }


    public function view(){
        $id = $this->request->param('id', 0, 'intval');

        $portalDramasModel = new PortalDramasModel();
        $post            = $portalDramasModel->where('id', $id)->find();

        //查询种子。
        $portalSeedModel = new PortalSeedModel();
        //可以分为多少季
        $seasonList            = $portalSeedModel->field('season,count(id)')->where('dramas_id', $id)->group('season')->order('season asc')->select();

        $seedList            = $portalSeedModel->where('dramas_id', $id)->order('season asc,episode asc')->select();
//
//
//        print_r($seedList);
//
//        foreach ($seedList as $item){
//            var_dump($item);
//            echo "</br>";
//        }






        $this->assign('post', $post);
        $this->assign('seasonList', $seasonList);
        $this->assign('seedList', $seedList);
//



        return $this->fetch(":dramas_view");
    }



    // 文章点赞
    public function doLike()
    {
        $this->checkUserLogin();
        $articleId = $this->request->param('id', 0, 'intval');


        $canLike = cmf_check_user_action("posts$articleId", 1);

        if ($canLike) {
            Db::name('portal_post')->where(['id' => $articleId])->setInc('post_like');

            $this->success("赞好啦！");
        } else {
            $this->error("您已赞过啦！");
        }
    }

    public function myIndex()
    {
        //获取登录会员信息
        $user = cmf_get_current_user();
        $this->assign('user_id', $user['id']);
        return $this->fetch('user/index');
    }

    //用户添加
    public function add()
    {
        return $this->fetch('user/add');
    }

    public function addPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $post   = $data['post'];
            $result = $this->validate($post, 'AdminArticle');
            if ($result !== true) {
                $this->error($result);
            }

            $portalPostModel = new PortalPostModel();

            if (!empty($data['photo_names']) && !empty($data['photo_urls'])) {
                $data['post']['more']['photos'] = [];
                foreach ($data['photo_urls'] as $key => $url) {
                    $photoUrl = cmf_asset_relative_url($url);
                    array_push($data['post']['more']['photos'], ["url" => $photoUrl, "name" => $data['photo_names'][$key]]);
                }
            }

            if (!empty($data['file_names']) && !empty($data['file_urls'])) {
                $data['post']['more']['files'] = [];
                foreach ($data['file_urls'] as $key => $url) {
                    $fileUrl = cmf_asset_relative_url($url);
                    array_push($data['post']['more']['files'], ["url" => $fileUrl, "name" => $data['file_names'][$key]]);
                }
            }
            $portalPostModel->adminAddArticle($data['post'], $data['post']['categories']);

            $this->success('添加成功!', url('Article/myIndex', ['id' => $portalPostModel->id]));
        }
    }

    public function select()
    {
        $ids                 = $this->request->param('ids');
        $selectedIds         = explode(',', $ids);
        $portalCategoryModel = new PortalCategoryModel();

        $tpl = <<<tpl
<tr class='data-item-tr'>
    <td>
        <input type='checkbox' class='js-check' data-yid='js-check-y' data-xid='js-check-x' name='ids[]'
                               value='\$id' data-name='\$name' \$checked>
    </td>
    <td>\$id</td>
    <td>\$spacer <a href='\$url' target='_blank'>\$name</a></td>
    <td>\$description</td>
</tr>
tpl;

        $categoryTree = $portalCategoryModel->adminCategoryTableTree($selectedIds, $tpl);

        $where      = ['delete_time' => 0];
        $categories = $portalCategoryModel->where($where)->select();

        $this->assign('categories', $categories);
        $this->assign('selectedIds', $selectedIds);
        $this->assign('categories_tree', $categoryTree);
        return $this->fetch('user/select');
    }
}
