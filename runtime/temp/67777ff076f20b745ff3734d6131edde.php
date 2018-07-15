<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:32:"../tpl/admin/menu\show_menu.html";i:1484634306;}*/ ?>
<div class="menu_dropdown bk_2">
    <?php if(!(empty($list) || ($list instanceof \think\Collection && $list->isEmpty()))): if(is_array($list) || $list instanceof \think\Collection): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu_1): $mod = ($i % 2 );++$i;?>
    <dl id="menu-article">
        <dt>
            <i class="fa <?php echo (isset($menu_1['ico']) && ($menu_1['ico'] !== '')?$menu_1['ico']:'fa-star'); ?>"></i>&nbsp;<?php echo (isset($menu_1['title']) && ($menu_1['title'] !== '')?$menu_1['title']:''); ?>
            <i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
        <dd>
            <ul>
                <?php if(!(empty($menu_1['_child']) || ($menu_1['_child'] instanceof \think\Collection && $menu_1['_child']->isEmpty()))): if(is_array($menu_1['_child']) || $menu_1['_child'] instanceof \think\Collection): $i = 0; $__LIST__ = $menu_1['_child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu_2): $mod = ($i % 2 );++$i;?>
                <li>
                    <a _href="<?php if(empty($menu_2['_child']) || ($menu_2['_child'] instanceof \think\Collection && $menu_2['_child']->isEmpty())): ?><?php echo Url($menu_2['url']); if(!(empty($menu_2['param']) || ($menu_2['param'] instanceof \think\Collection && $menu_2['param']->isEmpty()))): ?>?<?php echo $menu_2['param']; endif; else: ?>javascript:<?php endif; ?>" data-title="<?php echo (isset($menu_2['title']) && ($menu_2['title'] !== '')?$menu_2['title']:''); ?>" href="javascript:void(0)"><?php echo (isset($menu_2['title']) && ($menu_2['title'] !== '')?$menu_2['title']:''); ?></a>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; endif; ?>
            </ul>
        </dd>
    </dl>
    <?php endforeach; endif; else: echo "" ;endif; endif; ?>
</div>
<link rel="stylesheet" type="text/css" href="__plugin__/font-awesome/css/font-awesome.min.css" />