<?php
namespace app\admin\model;
use app\admin\model\MemberModel;
use think\Db;
Class AuditModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }
    //主播审核列表
    public function get_audit_list($model,$map)
    {
        $condition = !empty($model) ? $model->wheresql : null;
        $m = db_func('audit aud', 'sp_');
        return $m->where($condition)
            ->where($map)
            ->field('aud.*,m.num_id,m.phone')
            ->join('__MEMBER__ m','m.member_id = aud.mid ','LEFT')
            ->order('aud.status <> 0 ,aud.create_time')
            ->paginate(config('pre_page'));
    }

    public function get_user_info_by_id($id,$type)
    {
        empty($id) && wrong_return('id不能为空');
        $audit = db('audit')->where(['id' => $id,'type' => $type])->find();
        empty($audit) && wrong_return('未查询到相关信息');
        $mid = $audit['mid'];
        $user_info = db('member')->where('member_id',$mid)->find();
        empty($user_info) && wrong_return('查询相关人员信息错误');
        $audit_info =array(
            'id' =>$audit['id'],
            'num_id'=>$user_info['num_id'],
            'account'=>$user_info['account'],
            'nickname'=>$user_info['nick_name'],
            'user_face' => $user_info['user_face'],
            'true_name'=>$audit['true_name'],
            'identity_card'=>$audit['identity_card'],
            'phone'=>$user_info['phone'],
            'type'=>$audit['type'],
            'status'=>$audit['status'],
            'create_time' =>$audit['status'],
            'positive_img_url'=>$audit['positive_img_url'],
            'detailed_address' => $audit['detailed_address'],
            'negative_img_url' =>$audit['negative_img_url'],
            'industry' => $audit['industry'],
            'province' => $audit['province'],
            'city' => $audit['city']
        );
        if($type == 2){
            $audit_info['registration'] = $audit['registration'];
            $audit_info['business_img_url'] = $audit['business_img_url'];
            $audit_info['enterprise_name'] = $audit['enterprise_name'];
        }
        return $audit_info;
    }
}