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

use app\portal\model\PortalSeedModel;

class IndexController extends HomeBaseController
{
    public function index()
    {
        //读取3类数据。生肉、熟肉、字幕 每种3条数据。
        $portalSeedModel = new PortalSeedModel();
        $shengrou = $portalSeedModel->where(['status'=>1,'category'=>"生肉"])->order('gmt_modified desc')->paginate(3);
        $shurou = $portalSeedModel->where(['status'=>1,'category'=>"熟肉"])->order('gmt_modified desc')->paginate(3);
        $zimu = $portalSeedModel->where(['status'=>1,'category'=>"字幕"])->order('gmt_modified desc')->paginate(3);

        $this->assign('shengrou',$shengrou);
        $this->assign('shurou',$shurou);
        $this->assign('zimu',$zimu);

        return $this->fetch(':home');
    }
}
