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

use cmf\controller\AdminBaseController;
use app\portal\model\PortalSeedModel;
use app\portal\model\PortalDramasModel;
use think\Db;
use app\admin\model\ThemeModel;

class AdminSeedController extends AdminBaseController
{

    //没有传递剧集参数的页面。
    public function all(){

        $param = $this->request->param();

        $keyword = $this->request->param('keyword', "");

        // 查询状态为1的用户数据 并且每页显示10条数据
        $portalSeedModel = new PortalSeedModel();


        if (empty($keyword)){
            $list = $portalSeedModel->where(['status'=>1])->paginate(10);
        }else{
            $list = $portalSeedModel->where(['status'=>1])->where('title','like','%'.$keyword.'%')->paginate(10);
        }



        // 把分页数据赋值给模板变量list
        $this->assign('list', $list);


        $this->assign('keyword', isset($param['keyword']) ? $param['keyword'] : '');
        $this->assign('list', $list);
        $this->assign('page', $list->render());


        return $this->fetch();

    }
    /**
     * xx 剧集的种子列表。
     * @adminMenu(
     *     'name'   => '种子管理',
     *     'parent' => 'portal/AdminIndex/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '种子列表',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $param = $this->request->param();

        $id = $this->request->param('dramas_id', 0, 'intval');

        $keyword = $this->request->param('keyword', "");

        // 查询状态为1的用户数据 并且每页显示10条数据
        $portalSeedModel = new PortalSeedModel();

        $portalDramasModel = new PortalDramasModel();
        $dramas           = $portalDramasModel->where('id', $id)->find();
        $this->assign('dramas', $dramas);



        if (empty($keyword)){
            $list = $portalSeedModel->where(['status'=>1,'dramas_id'=>$id])->paginate(10);
        }else{
            $list = $portalSeedModel->where(['status'=>1,'dramas_id'=>$id])->where('title','like','%'.$keyword.'%')->paginate(10);
        }



        // 把分页数据赋值给模板变量list
        $this->assign('list', $list);


        $this->assign('keyword', isset($param['keyword']) ? $param['keyword'] : '');

        $this->assign('dramas_id', $id);

        $this->assign('list', $list);
        $this->assign('page', $list->render());


        return $this->fetch();
    }

    /**
     * 添加种子
     * @adminMenu(
     *     'name'   => '添加种子',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加种子',
     *     'param'  => ''
     * )
     */
    public function add()
    {

        $id = $this->request->param('dramas_id', 0, 'intval');
        $portalDramasModel = new PortalDramasModel();
        $dramas            = $portalDramasModel->where('id', $id)->find();
        $this->assign('dramas', $dramas);

        return $this->fetch();
    }

    /**
     * 添加文章提交
     * @adminMenu(
     *     'name'   => '添加文章提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加文章提交',
     *     'param'  => ''
     * )
     */
    public function addPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $post   = $data['post'];



            $result = $this->validate($post, 'AdminSeed');
            if ($result !== true) {
                $this->error($result);
            }

            $portalSeedModel = new PortalSeedModel();



            $portalSeedModel->adminAddSeed($data['post']);

            $data['post']['id'] = $portalSeedModel->id;



            $this->success('添加成功!', url('AdminSeed/edit', ['id' => $portalSeedModel->id]));
        }

    }

    /**
     * 编辑种子
     * @adminMenu(
     *     'name'   => '编辑种子',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑种子',
     *     'param'  => ''
     * )
     */
    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');

        $portalSeedModel = new PortalSeedModel();
        $post            = $portalSeedModel->where('id', $id)->find();
        $this->assign('dramas', $post->dramas);
        $this->assign('post', $post);


        return $this->fetch();
    }

    /**
     * 编辑种子提交
     * @adminMenu(
     *     'name'   => '编辑种子提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑种子提交',
     *     'param'  => ''
     * )
     */
    public function editPost()
    {

        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $post   = $data['post'];
            $result = $this->validate($post, 'AdminSeed');
            if ($result !== true) {
                $this->error($result);
            }

            $portalSeedModel = new PortalSeedModel();



            $portalSeedModel->adminEditSeed($data['post']);



            $this->success('保存成功!');

        }
    }

    /**
     * 种子删除
     * @adminMenu(
     *     'name'   => '种子删除',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '文章删除',
     *     'param'  => ''
     * )
     */
    public function delete()
    {
        $param           = $this->request->param();
        $portalSeedModel = new PortalSeedModel();

        if (isset($param['id'])) {
            $id           = $this->request->param('id', 0, 'intval');
            $result       = $portalSeedModel->where(['id' => $id])->find();
            $data         = [
                'object_id'   => $result['id'],
                'create_time' => time(),
                'table_name'  => 'portal_seed',
                'name'        => $result['title']
            ];
            $resultPortal =$portalSeedModel
                ->where(['id' => $id])
                ->update(['gmt_modified' => date('Y-m-d H:i:s'),'status'=>0]);

            if ($resultPortal) {
                Db::name('recycleBin')->insert($data);
            }
            $this->success("删除成功！", '');
        }

        if (isset($param['ids'])) {
            $ids     = $this->request->param('ids/a');
            $recycle = $portalSeedModel->where(['id' => ['in', $ids]])->select();
            $result  = $portalSeedModel->where(['id' => ['in', $ids]])->update(['gmt_modified' => date('Y-m-d H:i:s'),'status'=>0]);
            if ($result) {
                foreach ($recycle as $value) {
                    $data = [
                        'object_id'   => $value['id'],
                        'create_time' => time(),
                        'table_name'  => 'portal_seed',
                        'name'        => $value['title']
                    ];
                    Db::name('recycleBin')->insert($data);
                }
                $this->success("删除成功！", '');
            }
        }
    }



}
