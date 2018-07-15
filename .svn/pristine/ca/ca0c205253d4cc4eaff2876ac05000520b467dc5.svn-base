<?php
namespace app\admin\model;

Class ConfigModel
{
    /*** 获取列表 */
    public function get_list($model,$page)
    {
        $condition = !empty($model) ? $model->wheresql : null;
        $m = db_func('config c', 'sp_');
        return $m->where($condition)
            ->where('c.status', 'neq', '-1')
            ->join(['category_list l_1', 'sp_'], 'l_1.code = c.type', 'LEFT')
            ->join(['category_list l_2', 'sp_'], 'l_2.code = c.group', 'LEFT')
            ->order('c.editable,c.sort,c.id desc')
            ->field('c.*,l_1.name type_name,l_2.name group_name')
            ->paginate($page);
    }

    public function get_conf_list(){
        $m = db_func('config c', 'sp_');
        return $m
            ->where('c.status', 'neq', '-1')
            ->join(['category_list l_1', 'sp_'], 'l_1.code = c.type', 'LEFT')
            ->join(['category_list l_2', 'sp_'], 'l_2.code = c.group', 'LEFT')
            ->order('c.editable,c.sort,c.id desc')
            ->field('c.*,l_1.name type_name,l_2.name group_name')
            ->select();
    }

    /*** 新增或更新列表 */
    public function update($post)
    {
        $m = db_func('config');
        $code = $type = $title = $group = $extra = $tips = $value = $sort = null;
        extract($post);

        $data = array(
            "code" => $code,
            "type" => $type,
            "title" => $title,
            "group" => $group,
            "extra" => $extra,
            "tips" => $tips,
            "value" => $value,
            "sort" => $sort
        );

        if (!empty($id) && chk_id($id)) {
            $info = $m->where(array("id" => $id))->update($data);
            return $info !== false;
        } else {
            if ($m->where(array("code" => $code))->find()) {
                return '-1';
            }
            return $m->insert($data);
        }

    }


    /***根据列表id返回列表的详情*/
    public function get_info_by_id($id)
    {
        $m = db_func('config');
        return $m->where(['id' => $id])->find();
    }

    /***删除分类信息*/
    public function del($id)
    {
        $m = db_func('config');
        return $m->where(array("id" => $id))->delete();
    }

    /***保存配置*/
    public function save_config($code, $value)
    {
        $m = db_func('config');
        return $m->where(['code' => $code])->update(["value" => $value]) !== false;
    }

    /***获取全部配置*/
    public function get_all_conf(){
        return db_func('config')->where(['status'=>1])->field('code,value')->select();
    }
}