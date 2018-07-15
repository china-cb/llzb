<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:88:"C:\Users\admin\Documents\linglongzhibo\public/../app/core\view\unionpay\form_submit.html";i:1484984456;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>正在为您跳转到支付宝..</title>
</head>
<body>
<form action="<?php echo $url; ?>" target="_self" id="submit_form">
    <?php if(is_array($list) || $list instanceof \think\Collection): if( count($list)==0 ) : echo "" ;else: foreach($list as $k=>$vo): ?>
        <input type="hidden" name="<?php echo $k; ?>" value="<?php echo $vo; ?>">
    <?php endforeach; endif; else: echo "" ;endif; ?>
    <h3>正在提交数据，如果没有进入支付页面，请点击<input type="submit" value="提交" />继续提交</h3>
    <img src="/static/public/img/currency.jpg"/>
</form>
<script>
    document.getElementById("submit_form").submit();
</script>
</body>
</html>