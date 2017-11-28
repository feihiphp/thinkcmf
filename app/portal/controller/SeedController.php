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

class SeedController extends HomeBaseController
{


    public function view(){
        $id = $this->request->param('id', 0, 'intval');
        $portalSeedModel = new PortalSeedModel();
        $post            = $portalSeedModel->where('id', $id)->find();
        $this->assign('post', $post);

        return $this->fetch(":seed_view");
    }



}
