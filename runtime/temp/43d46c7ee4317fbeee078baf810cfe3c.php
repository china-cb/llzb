<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:41:"../tpl/index/user_center\company_ajx.html";i:1486619523;}*/ ?>
<div class="select_type">
    <h1>填写信息</h1>
  <label class="l_write l_write2">企业名称<input type="text/css" name="enterprise_name" value="<?php echo (isset($list['enterprise_name']) && ($list['enterprise_name'] !== '')?$list['enterprise_name']:''); ?>" placeholder="企业名称" class="w_addres"></label>
                     <div class="local_area">
                         <label class="l_write l_write2"><i class="i3s"></i>所属行业<input type="text/css" name="industry" value="<?php echo (isset($list['industry']) && ($list['industry'] !== '')?$list['industry']:'请选择'); ?>" class="local_input3" readonly></label>
                         <ul class="addres_ul1s addres_ul1s_1 addres_ul3s">
                             <li class="addres_li3">机构组织</li>
                             <li class="addres_li3">农林牧渔</li>
                             <li class="addres_li3">医药卫生</li>
                             <li class="addres_li3">建筑建材</li>
                             <li class="addres_li3">石油化工</li>
                             <li class="addres_li3">水利水电</li>
                             <li class="addres_li3">交通运输</li>
                             <li class="addres_li3">信息产业</li>
                             <li class="addres_li3">机械机电</li>
                             <li class="addres_li3">轻工食品</li>
                             <li class="addres_li3">服装纺织</li>
                             <li class="addres_li3">专业服饰</li>
                             <li class="addres_li3">安全防护</li>
                             <li class="addres_li3">环保绿化</li>
                             <li class="addres_li3">旅游休闲</li>
                             <li class="addres_li3">办公文教</li>
                             <li class="addres_li3">电子电工</li>
                             <li class="addres_li3">玩具礼品</li>
                             <li class="addres_li3">家居用品</li>
                             <li class="addres_li3">其它类型</li>
                         </ul>
                     </div>
                     <div class="local_area">
                         <label class="l_write l_write2 l_write1s"><i class="i3s"></i>所属地区<input type="text/css" name="" value="<?php echo (isset($list['province']) && ($list['province'] !== '')?$list['province']:'请选择'); ?>" class="local_input1" readonly></label>
                         <label class="l_write l_write2 l_write2s" style="left: 249px;"><i class="i3s"></i><input type="text/css" name="" value="<?php echo (isset($list['city']) && ($list['city'] !== '')?$list['city']:'请选择'); ?>" class="local_input2" readonly></label>
                         <ul class="addres_ul1s addres_ul1s_1 addres_ul1">
                             <li class="addres_li">江苏省</li>
                             <li class="addres_li">四川省</li>
                             <li class="addres_li">上海市</li>
                             <li class="addres_li">北京市</li>
                         </ul>
                         <div>
                             <ul class="addres_ul1s addres_ul2s addres_ul2s_2">
                                 <li class="addres_li2">徐州市</li>
                                 <li class="addres_li2">南京市</li>
                                 <li class="addres_li2">苏州市</li>
                                 <li class="addres_li2">扬州市</li>
                                 <li class="addres_li2">泰州市</li>
                                 <li class="addres_li2">无锡市</li>
                             </ul>
                             <ul class="addres_ul1s addres_ul2s addres_ul2s_2">
                                 <li class="addres_li2">自贡市</li>
                                 <li class="addres_li2">成都市</li>
                                 <li class="addres_li2">广安市</li>
                                 <li class="addres_li2">南充市</li>
                                 <li class="addres_li2">达州市</li>
                                 <li class="addres_li2">遂宁市</li>
                                 <li class="addres_li2">眉山市</li>
                                 <li class="addres_li2">攀枝花市</li>
                             </ul>
                             <ul class="addres_ul1s addres_ul2s addres_ul2s_2">
                                 <li class="addres_li2">闵行区</li>
                                 <li class="addres_li2">浦东新区</li>
                                 <li class="addres_li2">虹口区</li>
                                 <li class="addres_li2">徐汇区</li>
                                 <li class="addres_li2">宝山区</li>
                                 <li class="addres_li2">松江区</li>
                                 <li class="addres_li2">闸北区</li>
                                 <li class="addres_li2">静安区</li>
                             </ul>
                             <ul class="addres_ul1s addres_ul2s addres_ul2s_2">
                                 <li class="addres_li2">东城区</li>
                                 <li class="addres_li2">西城区</li>
                                 <li class="addres_li2">朝阳区</li>
                                 <li class="addres_li2">宣武区</li>
                                 <li class="addres_li2">崇文区</li>
                             </ul>
                         </div>
                         <div style="clear: both"></div>
                     </div>
                         
                       <label class="l_write l_write2 ">详细地址<input type="text/css" name="detailed_address" value="<?php echo (isset($list['detailed_address']) && ($list['detailed_address'] !== '')?$list['detailed_address']:''); ?>" placeholder="填写详细地址" class="w_addres"></label>
                       <label class="l_write l_write2 ">营业执照注册号<input type="text/css" name="registration" value="<?php echo (isset($list['registration']) && ($list['registration'] !== '')?$list['registration']:''); ?>" placeholder="营业执照注册号" class="w_addres"></label>
                       <label class="l_write l_write2">法人姓名<input type="text/css" name="true_name" value="<?php echo (isset($list['true_name']) && ($list['true_name'] !== '')?$list['true_name']:''); ?>" placeholder="法人姓名" class="w_addres"></label>
                       <label class="l_write l_write2">法人身份证号<input type="text/css" name="identity_card" value="<?php echo (isset($list['identity_card']) && ($list['identity_card'] !== '')?$list['identity_card']:''); ?>" placeholder="法人身份证号" class="w_addres"></label>
                    </div>
<div class="select_type">
     <h1>提交资料</h1>
     <a class="prompts_left">支持jpg、png格式图片，大小不超过5M</a>

     <h3 class="positive">营业执照</h3>
     <input type="hidden" id="business_img_url" value="">
     <ul class="upload_positive">
         <li>
             <form id="form3">
                 <label>
                 <span class="business_img <?php if(!(empty($list['business_img_url']) || ($list['business_img_url'] instanceof \think\Collection && $list['business_img_url']->isEmpty()))): ?>span_succes<?php endif; ?>"><i></i>上传文件</span>
                 <input class="file_upload box_img" type="file" accept="image" id="company_img" name="c_img" /><span class="sf"></span></label>
                 <?php if(empty($list['business_img_url']) || ($list['business_img_url'] instanceof \think\Collection && $list['business_img_url']->isEmpty())): ?>
                 <img class="preview" src="__static__/index/src/img/admin/sitives.png">
                 <?php else: ?>
                 <img class="preview" src="<?php echo \think\Config::get('CONFIG_CDN_URL'); ?><?php echo (isset($list['business_img_url']) && ($list['business_img_url'] !== '')?$list['business_img_url']:''); ?>"/>
                 <?php endif; ?>
             </form>
         </li>

         <li>
             示例照片
             <i></i>
         </li>
         <li>
             <img src="__static__/index/src/img/admin/business_licence.jpg" alt="" class="business" />
         </li>
     </ul>

     <h3 class="positive">法人身份证正面照</h3>
     <input type="hidden" id="positive_img_url" value="">
     <ul class="upload_positive">
         <li>
             <form id="form1">
                 <label> <span class="positive_img <?php if(!(empty($list['positive_img_url']) || ($list['positive_img_url'] instanceof \think\Collection && $list['positive_img_url']->isEmpty()))): ?>span_succes<?php endif; ?>"><i></i>上传文件</span><input class="file_upload box_img" type="file" accept="image" name="img" id="positive_img" /><span class="sf"></span></label>
                 <?php if(empty($list['positive_img_url']) || ($list['positive_img_url'] instanceof \think\Collection && $list['positive_img_url']->isEmpty())): ?>
                 <img class="preview" src="__static__/index/src/img/admin/sitives.png">
                 <?php else: ?>
                 <img class="preview" src="<?php echo \think\Config::get('CONFIG_CDN_URL'); ?><?php echo (isset($list['positive_img_url']) && ($list['positive_img_url'] !== '')?$list['positive_img_url']:''); ?>"/>
                 <?php endif; ?>
             </form>
         </li>
         <li>
             示例照片
             <i></i>
         </li>
         <li>
             <img src="__static__/index/src/img/admin/positive.png" alt="">
         </li>
     </ul>

     <h3 class="positive">法人身份证反面照</h3>
     <input type="hidden" id="negative_img_url" value="">
     <ul class="upload_positive">
         <li>
             <form id="form2">
                 <label> <span class="negative_img <?php if(!(empty($list['negative_img_url']) || ($list['negative_img_url'] instanceof \think\Collection && $list['negative_img_url']->isEmpty()))): ?>span_succes<?php endif; ?>"><i></i>上传文件</span><input class="file_upload box_img" type="file" accept="image" name="a_image" id="negative_img" value="" /><span class="sf"></span></label>
             </form>
             <?php if(empty($list['negative_img_url']) || ($list['negative_img_url'] instanceof \think\Collection && $list['negative_img_url']->isEmpty())): ?>
             <img class="preview"  src="__static__/index/src/img/admin/sitives.png">
             <?php else: ?>
             <img class="preview" src="<?php echo \think\Config::get('CONFIG_CDN_URL'); ?><?php echo (isset($list['negative_img_url']) && ($list['negative_img_url'] !== '')?$list['negative_img_url']:''); ?>"/>
             <?php endif; ?>
         </li>
         <li>
             示例照片
             <i></i>
         </li>
         <li>
             <img src="__static__/index/src/img/admin/positive.png" alt="">
         </li>
     </ul>

    <?php switch($rt['state']): case "0": ?><a href="javascript:" class="sub_go company_up ">提交</a><?php break; case "1": ?><a href="javascript:" class="sub_go  sub_as"> 信息正在审核中...</a><?php break; case "2": ?><div class="types_ad">111111</div><?php break; case "-1": ?><a href="javascript:" class="sub_go company_up ">提交</a>{<?php break; default: ?><a href="javascript:" class="sub_go company_up ">提交</a>
    <?php endswitch; ?>
</div>

