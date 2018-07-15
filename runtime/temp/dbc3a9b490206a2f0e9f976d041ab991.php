<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:37:"../tpl/index/index\get_help_info.html";i:1486274140;}*/ ?>
<div class="block">
    <div class="help_docs">
        <h1 class="title_path">
            <a>
               <?php echo (isset($title) && ($title !== '')?$title:''); ?>
            </a>>>
            <a class="top-category" data-id="<?php echo (isset($help_info['hid']) && ($help_info['hid'] !== '')?$help_info['hid']:''); ?>" data-value="<?php echo (isset($title) && ($title !== '')?$title:''); ?>"><?php echo (isset($help_info['title']) && ($help_info['title'] !== '')?$help_info['title']:'--'); ?></a>>>
            <span><?php echo (isset($help_info['name']) && ($help_info['name'] !== '')?$help_info['name']:'--'); ?></span>
        </h1>
        <div style="clear: both;">

        </div>
        <h2 class="title_h2">
            <?php echo (isset($help_info['name']) && ($help_info['name'] !== '')?$help_info['name']:'--'); ?>
        </h2>
        <section class="docs_main">
            <?php echo (isset($help_info['content']) && ($help_info['content'] !== '')?$help_info['content']:'--'); ?>
        </section>
    </div>
</div>

