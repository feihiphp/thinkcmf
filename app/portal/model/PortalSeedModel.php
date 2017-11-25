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
namespace app\portal\model;

use think\Model;

class PortalSeedModel extends Model
{




    /**
     * 关联 user表
     * @return $this
     */
    public function user()
    {
        return $this->belongsTo('UserModel', 'user_id')->setEagerlyType(1);
    }



    /**
     * 后台管理添加美剧
     * @param array $data 美剧数据
     * @return $this
     */
    public function adminAddSeed($data)
    {

        $data['user_id'] = cmf_get_current_admin_id();
        $data['status'] = 1;
        $data['down_num'] = 0;
        $data['gmt_create']=$data['gmt_modified'] = date('Y-m-d H:i:s');


        $this->allowField(true)->data($data, true)->isUpdate(false)->save();



        return $this;

    }

    /**
     * 后台管理编辑美剧
     * @param array $data 美剧数据
     * @return $this
     */
    public function adminEditDramas($data)
    {

        unset($data['username']);
        $data['gmt_modified'] = date('Y-m-d H:i:s');
        $this->allowField(true)->isUpdate(true)->data($data, true)->save();
        return $this;

    }



}
