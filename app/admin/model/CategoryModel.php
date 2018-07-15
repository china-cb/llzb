<?php
namespace app\admin\model;

use think\Db;

Class CategoryModel
{
    public function __construct()
    {
    }


    /*** 获取列表 */
    public function get_category($model)
    {
        $condition = $model->wheresql;
        $m = db_func('category', 'sp_');
        return $m->where($condition)->where('status', 'neq', '-1')->order('id desc')->paginate(config('pre_page'));
    }


    /*** 新增或更新列表 */
    public function update_cate($post)
    {
        $m = db_func('category');
        $id = $code = $name = $tips = $code = null;
        extract($post);

        $data = array(
            "name" => $name,
            "tips" => $tips,
            "code" => $code,
            "create_time" => NOW_TIME
        );

        if (!empty($id)) {
            $info = $m->where(array("id" => $id, 'allow_exec' => 'true'))->update($data);
            return $info !== false;
        } else {
            if ($m->where(array("code" => $code))->find()) {
                return '-1';
            }
            return $m->insert($data);
        }

    }

    /*** 新增或更新列表项 */
    public function update_cate_list($post)
    {
        $m = db_func('category_list');
        $mid = $id = $pid = $sort = $imgid = $url = $name = $tips = $code = null;
        extract($post);

        $data = array(
            "pid" => $pid,
            "sort" => $sort,
            "mid" => $mid,
            "imgid" => $imgid,
            "code" => $code,
            "name" => $name,
            "url" => $url,
            "tips" => $tips,
        );


        if (!empty($id)) {
            $info = $m->where(array("id" => $id))->update($data);
            return $info !== false;
        } else {
            if ($m->where(array("code" => $code))->find()) {
                return '-1';
            }
            return $m->insert($data);
        }

    }

    /*** 获取列表 */
    public function get_category_list($model)
    {
        $condition = $model->wheresql;
        $m = db_func('category_list');
        return $m->where($condition)->where('status', 'neq', '-1')->order('id desc')->paginate(config('pre_page'));
    }

    /***根据列表id返回列表的详情*/
    public function get_cate_info_by_id($id)
    {
        $m = db_func('category');
        return $m->where(['status' => "1", 'id' => $id])->find();
    }

    /***返回当前父级id下列表*/
    public function get_list_by_pid($id)
    {
        $m = db_func('category_list');
        return $m->where(["status" => "1", "pid" => $id])->select();
    }

    /***删除分类信息*/
    public function del_category($id)
    {
        $m = db_func('category');
        return $m->where(array("id" => $id, 'allow_exec' => 'true'))->update(array('status' => -1));
    }

    /***删除分类信息项目*/
    public function del_category_list($id)
    {
        $m = db_func('category_list');
        return $m->where(array("id" => $id))->update(array('status' => -1));
    }

    /***根据cat的code获取list中的列表*/
    public function get_list_by_code_mid($code)
    {
        $info = $this->get_category_info_by_code($code);
        if (!$info) return false;
        return $this->get_list_by_mid($info["id"]);
    }
    /***根据mid获取list列表*/
    public function get_list_by_mid($mid)
    {
        return db_func('category_list')->where(array("mid" => $mid, 'status' => 1))->order('sort desc')->select();
    }


    public function get_category_info_by_code($code)
    {
        return db_func('category')->where(array("code" => $code))->find();
    }



    public function update_child($post)
    {
        $id = $pid = $orders = $mid = $imgid = $code = $status = $name = $url = $desc = $sumclick = null;
        extract($post);
        $data = array(
            "pid" => $pid,
            "orders" => $orders,
            "mid" => $mid,
            "imgid" => $imgid,
            "code" => $code,
            "status" => $status,
            "name" => $name,
            "url" => $url,
            "desc" => $desc,
            "sumclick" => $sumclick
        );

        if (!empty($id) && is_numeric($id)) {
            $info = $m_list->where(array("id" => $id))->update($data);
            return $info !== false;
        } else {
            return $m_list->insert($data);
        }

    }

    //新增分类
    public function category_insert($post)
    {
        $data = array(
            "name" => $post['name'],
            "code" => $post['code'],
            "type" => $post['type'],
            "tips" => $post['tips'],
            "createtime" => $post['createtime']);
        return $m->insert($data);
    }

    //保存分类
    public function category_save($post)
    {
        extract($post);
        $data = array(
            "name" => $name,
            "type" => $type,
            "tips" => $tips);
        return $m->where(array("id" => $id))->update($data);
    }


    //根据id返回子分类主菜单的详细内容
    public function get_cate_list_info_by_id($id)
    {
        $m = db_func('category_list');
        return $m->where(array("id" => $id))->find();
    }

    //不存在返回false
    public function check_class_code($type)
    {
        return $m->where(array("code" => $type))->find();
    }

    //根据mid获取当前目录下的菜单
    public function get_category_list_by_mid($mid)
    {
        $m_list = db_func('category_list');
        return $m_list->where(array("status" => "1", "mid" => $mid))->order('sort desc,id desc')->select();
    }

    //根据code获取分类一级列表
    public function get_category_by_code($code)
    {
        //获取父级id
        $m_category = M("category", "sp_");
        $m_category_list = M("category_list", "sp_");
        $p_info = $m_category->where(array("code" => $code))->field("id")->find();

        //获取该父级id下的一级列表
        return $m_category_list->where('status <> -1 AND mid = ' . $p_info['id'])->order('id desc,`orders` desc')->select();
    }


    //删除子分类信息
    public function del_category_child($id)
    {
        return $m_list->where(array("id" => $id))->update(array('status' => -1));
    }

    //删除分类下全部子分类
    public function del_sub_category($mid)
    {
        return $m_list->where(array("mid" => $mid))->delete();
    }

    //检测分类mid是否存在
    public function check_subclass_mid($mid)
    {
        return $m->where(array("status" => "1", "mid" => $mid))->find();
    }

    /**+
     *作用：检测父级id是否存在
     *返回：不存在返回false
     */
    public function checkSubclassPid($pid)
    {
        return $m_list->where(array("status" => "1", "id" => $pid))->find();
    }

    /**+
     *作用：检测是否存在分类id
     *返回：不存在返回false
     */
    public function checkSubclassId($id)
    {
        return $m_list->where(array("status" => "1", "id" => $id))->find();
    }

    /**+
     *作用：修改名称的Service
     *返回：修改失败返回false,成功返回影响的记录数
     */
    public function subclassRename($post)
    {
        $data['name'] = $post['name'];
        return $m_list->where(array("status" => "1", "id" => $post["id"]))->update($data);
    }

    /**+
     *作用：新增一条分类
     *返回：成功返回true
     */
    public function subclassAdd($post)
    {
        $data = array(
            'name' => $post['name'],
            'pid' => $post['pid'],
            'mid' => $post['mid'],
            'status' => "1"
        );
        return $m_list->insert($data);
    }


    /**+
     *作用：删除分类
     *返回：有返回true
     */
    public function subclassDel($id)
    {
        return $m_list->where(array("id" => $id))->update(array("status" => "-1"));
    }


    /*
    * 作用: 粘贴分类
    * 参数: 操作id  新pid
    */
    public function subclassPaste($post)
    {
        $data['pid'] = $post['pid'];
        return $m_list->where(array("status" => "1", "id" => $post["id"]))->update($data);
    }

    /*
    * 作用: 设置识别码
    * 参数: 操作id  识别码code
    */
    public function setCode($post)
    {
        $data['code'] = $post['code'];
        return $m_list->where(array("status" => "1", "id" => $post["id"]))->update($data);
    }

    /*
    * 作用: 设置url
    * 参数: 操作id  url
    */
    public function setUrl($post)
    {
        $data['url'] = $post['url'];
        return $m_list->where(array("status" => "1", "id" => $post["id"]))->update($data);
    }

    /*
    * 作用: 设置Img
    * 参数: 操作id  Img

    */
    public function setImg($post)
    {
        $data['imgid'] = $post['imgid'];
        return $m_list->where(array("status" => "1", "id" => $post["id"]))->update($data);
    }

    /*
    * 作用: 检测识别码是否已存在
    * 参数: 操作id  识别码code
    */
    public function checkCode($post)
    {
        $getMidList = $m_list->where(array("status" => "1", "id" => $post["id"]))->find();
        $mid = $getMidList['mid'];

        return $m_list->where(array("status" => "1", "mid" => $mid, "code" => $post["code"]))->find();
    }

    /*
    * 作用: 查看识别码
    * 参数: 操作id
    */
    public function seeCode($id)
    {
        return $m_list->where(array("status" => "1", "id" => $post["id"], "id" => $id))->find();
    }

    /*
    * 作用: 检测图片是否存在且为本人上传
    * 参数: 操作id
    */
    public function checkImgId($post)
    {
        return M('images')->where(array("status" => "1", "id" => $post["id"], "memberid" => $post['memberid']))->find();
    }

    /*
    * 作用: 设置描述Desc
    * 参数: 操作id  Desc
    */
    public function setDesc($post)
    {
        $data['desc'] = $post['desc'];

        return $m_list->where(array("status" => "1", "id" => $post["id"]))->update($data);
    }


    //根据id获取当前目录下的菜单
    public function get_class_list($mid)
    {
        return $m_list->where(array("status" => "1", "mid" => $mid))->select();
    }

    public function get_category_list_info_by_code($code)
    {
        return $m_list->where(array("code" => $code))->find();
    }







    public function get_son_category_info($id)
    {
        return $m_list->where(['id' => $id])->find();
    }

    public function get_cate_list_root_list_by_mid($mid)
    {
        return $m_list->where(array("mid" => $mid, "pid" => 0))->select();
    }




    //获取mid下某pid的目录列表
    public function get_mid_pid_list($mid, $pid)
    {
        return $m_list->where(array("status" => "1", "mid" => $mid, "pid" => $pid))->select();
    }

    //添加导航URL
    public function nav_insert($post)
    {
        extract($post);
        $data = array(
            "rid" => $rid,
            "cid" => $cid,
            "name" => $name,
            "show_img" => $show_img,
            "indexes" => $indexes,
            "target" => $target,
            "url" => $url,
            "img" => $img,
            "status" => '1',
            "order_num" => $order_num,
        );

        $m_nav = M('nav');
        return $m_nav->insert($data);
    }


    //保存导航URL
    public function nav_save($post)
    {
        $rid = $cid = $name = $show_img = $indexes = $target = $url = $img = $order_num = $mobile_icon = '';
        extract($post);
        $data = array(
            "rid" => $rid,
            "cid" => $cid,
            "name" => $name,
            "show_img" => $show_img,
            "indexes" => $indexes,
            "target" => $target,
            "url" => $url,
            "img" => $img,
            "order_num" => $order_num,
            'mobile_icon' => $mobile_icon
        );
        $m_nav = M('nav');
        return $m_nav->where(array("id" => $post["id"]))->update($data);
    }

    //执行更新操作
    public function update2($post)
    {
        $orders = $status = $name = $tips = $code = $type1 = $mobile_icon = '';
        extract($post);
        $data = array(
            "orders" => $orders,
            "status" => $status,
            "name" => $name,
            "tips" => $tips,
            "code" => $code,
            "type" => $type1,
            'edit_status' => 1,
            'del_status' => 1,
            "createtime" => time()
        );

        if ($post['type'] == "edit") {
            $res = $m->where(array("id" => $post['id']))->update($data);
            return $res !== false;
        } else if ($post['type'] == "add") {
            $res = $m->insert($data);
        } else {
            return false;
        }
        return $res;
    }

    //获取子分类列表
    public function get_son_cate_list($post)
    {
        $m = M('category_list', 'sp_');
        $sql = "SELECT SQL_CALC_FOUND_ROWS  *
        FROM  sp_category_list
        WHERE  status <> '-1' " . $post->wheresql .
            " ORDER BY id desc " . $post->limitData;

        $sql_count = "SELECT FOUND_ROWS() as num";
        $info = $m->query($sql);
        $num = $m->query($sql_count);

        $rt["data"] = $info;
        $rt["count"] = $num[0]["num"];
        return $rt;

    }

    public function get_son_cate_id_name($pid)
    {
        return $m_list->field('id,name')->where(['pid' => $pid, 'status' => 1])->select();
    }

    //删除子分类
    public function son_cat_del($id)
    {
        $res = M('card')->field('id')->where(['cat_id' => $id, 'status' => 1])->count();
        if ($res > 0) {
            return false;
        }
        return $m_list->where(['id' => $id])->update(['status' => '-1']);
    }

    //执行更新操作
    public function update3($post)
    {
        $data = array(
            "name" => !empty($post['name']) ? $post['name'] : '',
            "pid" => !empty($post['pid']) ? $post['pid'] : '',
            "orders" => !empty($post['orders']) ? $post['orders'] : '',
            "mid" => !empty($post['mid']) ? $post['mid'] : '',
            "style" => !empty($post['style']) ? $post['style'] : '',
            "code" => !empty($post['code']) ? $post['code'] : '',
            "imgid" => !empty($post['imgid']) ? $post['imgid'] : '',
            "status" => !empty($post['status']) ? $post['status'] : '',
            "url" => !empty($post['url']) ? $post['url'] : '',
            "desc" => !empty($post['desc']) ? $post['desc'] : '',
            "sumclick" => !empty($post['sumclick']) ? $post['sumclick'] : '',
            "img_url" => !empty($post['img_url']) ? $post['img_url'] : '',
            "icon" => !empty($post['icon']) ? $post['icon'] : '',
            'edit_status' => 1,
            'del_status' => 1,
            "mobile_icon" => !empty($post['mobile_icon']) ? $post['mobile_icon'] : ''

        );

        if ($post['type'] == "edit") {
            $res = $m_list->where(array("id" => $post['id']))->update($data);
            return $res !== false;
        } else if ($post['type'] == "add") {
            $res = $m_list->insert($data);
        } else {
            return false;
        }
        return $res;
    }

    //获取分类类型
    public function get_cate_type($id)
    {
        return $m->where(array('id' => $id))->find()['type'];
    }

    //验证父级分类选择是否合法
    public function get_son_cates($id)
    {
        $arr = array();
        $data = array();
        $cates = $m_list->field('id,name,pid')->where(array('pid' => $id))->select();
        if (!empty($cates)) {
            foreach ($cates as $cate) {
                $data = $this->get_son_cates($cate['id']);
            }

        }

        return array_merge($arr, $cates, $data);

    }

    public function get_select_data($data)
    {
        $arr = array();
        foreach ($data as $item) {
            $arr[$item['id']] = $item['name'];

        }
        return $arr;

    }


}