<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - 商品列表 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
</head>
<body>
<h1>
	<?php if($_page_btn_name): ?>
    <span class="action-span"><a href="<?php echo $_page_btn_link; ?>"><?php echo $_page_btn_name; ?></a></span>
    <?php endif; ?>
    <span class="action-span1"><a href="#">管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo $_page_title; ?> </span>
    <div style="clear:both"></div>
</h1>

 <!-- 内容 --> 


<div class="main-div">
    <form name="main_form" method="POST" action="/index.php/Admin/GoodAttr/edit/id/9.html" enctype="multipart/form-data" >
    	<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
          <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">属性所属类型</td>
                <td>
               <?php buildSelect('good_type', 'type_id', 'id', 'type_name', $data['type_id'] )?>
                </td>
            </tr>
            <tr>
                <td class="label">属性名称：</td>
                <td>
  <input  type="text" name="attr_name" value="<?php echo $data['attr_name']?>" />
                </td>
            </tr>
            <tr>
                <td class="label">属性是否可选</td>
                  <td>
                    
                    <input  type="radio" name="atrr_type" value="1" <?php if($data['atrr_type']==1) echo "checked='checked'"?>/>唯一属性
                     <input  type="radio" name="atrr_type" value="2" <?php if($data['atrr_type']==2) echo "checked='checked'"?>/>单选属性
                      <input  type="radio" name="atrr_type" value="3" <?php if($data['atrr_type']==3) echo "checked='checked'"?>/>多选属性
                </td>
            </tr>
            <tr>
                <td class="label">属性的录入方式：</td>
 <td>
                    <input  type="radio" name="attr_input_type" value="1" <?php if($data['attr_input_type']==1) echo "checked='checked'"?>/>单行文本手工录入
                    <input  type="radio" name="attr_input_type" value="2" <?php if($data['attr_input_type']==2) echo "checked='checked'"?>/>从下面的列表选择(一行代表一个可选值)
                    <input  type="radio" name="attr_input_type" value="3" <?php if($data['attr_input_type']==3) echo "checked='checked'"?>/>多行文本框
                </td>
            </tr>
            <tr>
                <td class="label">属性的可选值：</td>
                <td>
                    <textarea  rows='20' cols='100' name="attr_value"><?php echo $data['attr_value']?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="99" align="center">
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
    </form>
</div>

<link href="/Public/umeditor1_2_2-utf8-php/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
<script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.min.js"></script>
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/lang/zh-cn/zh-cn.js"></script>

<script>
var um = UM.getEditor('attr_value', {
	initialFrameWidth:"100%"
});
</script>

<div id="footer"> 39期 </div>
</body>
</html>