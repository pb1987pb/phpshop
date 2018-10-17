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

<style>
#ul_pic_list li{margin:5px;list-style-type:none;}
#add{width: 50px}
</style>

<div class="tab-div" id='app'>
    <div id="tabbar-div">
        <p>
            <span class="tab-front">通用信息</span>
            <span class="tab-back">商品描述</span>
            <span class="tab-back">会员价格</span>
            <span class="tab-back">商品属性</span>
            <span class="tab-back">商品相册</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="/index.php/Admin/Goods/add.html" method="post">
        	<!-- 基本信息 -->
            <table width="90%" class="tab_table" align="center">
         	<tr>
                    <td class="label">所在品牌：</td>
                    <td>
                <?php buildSelect('brand', 'brand_id', 'id', 'brand_name'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="label">所属主分类：</td>
                    <td>
                   <select name="category_id">
						<option value="">选择主分类</option>
						<?php foreach ($parentData as $k => $v): ?>	
                                                <option value="<?php echo $v['id']; ?>"><?php echo str_repeat('-', 8*$v['level']).$v['catename']; ?></option>
						<?php endforeach; ?>					
                                        </select>
                    </td>
                </tr>
                  <tr>
                      <td class="label">所属扩展分类：<span id='add'>添加一个扩展分类</span></td>
                    
                      <td class="catwrap">
                        <select name="cat_id[]" class="cat">
						<option value="">选择扩展分类</option>
						<?php foreach ($parentData as $k => $v): ?>	
                                                <option value="<?php echo $v['id']; ?>"><?php echo str_repeat('-', 8*$v['level']).$v['catename']; ?></option>
						<?php endforeach; ?>					
                                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" size="60" />
                    <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td class="label">LOGO：</td>
                    <td><input type="file" name="logo" size="60" /></td>
                </tr>
                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="0" size="20" />
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="0" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="is_on_sale" value="是" checked="checked" /> 是
                        <input type="radio" name="is_on_sale" value="否" /> 否
                    </td>
                </tr>
                     <tr>
                         
                    <td class="label">是否删除：</td>
                    <td>
                       <input type="radio" name="is_delete" value="是"  /> 是
                        <input type="radio" name="is_delete" value="否" checked="checked"/> 否
                    </td>
                </tr>
                  <tr>
                    <td class="label">促销信息：</td>
                    <td>
                        促销价格：￥<input type="type" name="promote_price" value=""  /> 元<br/>
                      促销开始时间：<input type="text" name="promote_start_date" class="test-item"/> <br/>
                       促销结束时间：<input type="text" name="promote_end_date" class="test-item"/> 
                    </td>
                </tr>
                   <tr>
                         
                    <td class="label">是否新品：</td>
                    <td>
                       <input type="radio" name="is_new" value="是"  /> 是
                        <input type="radio" name="is_new" value="否" checked="checked"/> 否
                    </td>
                </tr>
                   <tr>
                         
                    <td class="label">是否热卖：</td>
                    <td>
                       <input type="radio" name="is_hot" value="是"  /> 是
                        <input type="radio" name="is_hot" value="否" checked="checked"/> 否
                    </td>
                </tr>
                   <tr>
                         
                    <td class="label">是否精品：</td>
                    <td>
                       <input type="radio" name="is_best" value="是"  /> 是
                        <input type="radio" name="is_best" value="否" checked="checked"/> 否
                    </td>
                </tr>
                 <tr>
                         
                    <td class="label">是否推荐楼层：</td>
                    <td>
                       <input type="radio" name="is_floor" value="是"  /> 是
                        <input type="radio" name="is_floor" value="否" checked="checked"/> 否
                    </td>
                </tr>
                 <tr>
                         
                    <td class="label">排序字段：</td>
                    <td>
                       <input type="text" name="sort_num" value="100"  /> 
                       
                    </td>
                </tr>
            </table>
            <!-- 商品描述 -->
            <table style="display:none;" width="100%" class="tab_table" align="center">
            	<tr>
                    <td>
                        <textarea id="goods_desc" name="goods_desc"></textarea>
                    </td>
                </tr>
            </table>
            <!-- 会员价格 -->
            <table style="display:none;" width="90%" class="tab_table" align="center">
            	<tr>
                    <td>
                     <?php foreach($levelData as $k => $v): ?>
                    
                     <p><?php echo $v['level_name']; ?>：￥  <input style='padding-left:20px;' name="price[<?php echo $v['id']; ?>]" type='text' size="20"></p>
                     <?php endforeach; ?>
                    </td>
                </tr>
            </table>
            <!-- 商品属性 -->
            <table style="display:none;" width="90%" class="tab_table" align="center">
            	<tr>
                      
                    <td> 商品类型：<?php buildSelect('good_type', 'type_id', 'id', 'type_name')?></td>
                    
                </tr>
                	<tr>
                      
                    <td> 
                        <ul id='attr_list'>
                            
                            
                        </ul>
                    </td>
                    
                </tr>
            </table>
            <!-- 商品相册 -->
            <table style="display:none;" width="100%" class="tab_table" align="center">
            	<tr>
            	<td>
            		<input id="btn_add_pic" type="button" value="添加一张" />
            		<hr />
            		<ul id="ul_pic_list"></ul>
            	</td>
            	</tr>
            </table>
            
            <div class="button-div">
                <input type="submit" value=" 确定 " class="button"/>
                <input type="reset" value=" 重置 " class="button" />
            </div>
            
        </form>
    </div>
</div>


<!--导入在线编辑器 -->
<link href="/Public/umeditor1_2_2-utf8-php/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
<script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.min.js"></script>
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/lang/zh-cn/zh-cn.js"></script>
<script src="/Public/layDate-v5.0.9/laydate/laydate.js" type="text/javascript"></script>
<script>
UM.getEditor('goods_desc', {
	initialFrameWidth : "100%",
	initialFrameHeight : 350
});



lay('.test-item').each(function(){
  laydate.render({
    elem: this
    ,trigger: 'click'
    ,type: 'datetime'
    ,min: '2016-10-14'
  ,max: '2080-10-14'
  });
}); 
/******** 切换的代码 *******/
$("#tabbar-div p span").click(function(){
  
	// 点击的第几个按钮
	var i = $(this).index();
	// 先隐藏所有的table
	$(".tab_table").hide();
	// 显示第i个table
	$(".tab_table").eq(i).show();
	// 先取消原按钮的选中状态
	$(".tab-front").removeClass("tab-front").addClass("tab-back");
	// 设置当前按钮选中
	$(this).removeClass("tab-back").addClass("tab-front");
});

// 添加一张
$("#btn_add_pic").click(function(){
	var file = '<li><input type="file" name="pic[]" /></li>';
	$("#ul_pic_list").append(file);
});
//添加扩展分类
$("#add").click(function(){
	
	$(".catwrap").append($('.cat').eq(0).clone());
});
$('select[name="type_id"]').change(function(){
        var id=$(this).val();
      if(id>0)
      {
          // 大于0就表示选择了，就发送ajax 请求
                          $.ajax({
  url:"<?php echo U('getAllType','',FALSE)?>/id/"+id,
  dataType:"json",
       success:function(res){
//           把服务器返回的属性循环拼成一个li字符串，并显示在页面上
    var li="";
    //下面这个用jq是比较好的，循环数组
    res.forEach(function(v,i){
        li+='<li>';
        if(v.atrr_type!=1){ 
            //不是1就是不是唯一属性 ，不是唯一属性就可以＋,
         
            li+='<a href="javascript:;" onclick="addNewAttr(this);">+</a>';
        }
        li+=v.attr_name+"：";
        if(v.attr_input_type==1){
            //等于1是文本框
            li+="<input type='text' name='attrmes["+v.id+"][]'/>";
        }else if(v.attr_input_type==3){
            //等于3是文本域
             li+="<textarea name='attrmes["+v.id+"][]'>";
              li+= "</textarea>";
        }else if(v.attr_input_type==2){
            li+="<select name='attrmes["+v.id+"][]'><option value='' >请选择</option>";
           var _attr =v.attr_value.split(/[(\r\n)\r\n]+/); //换行符隔开获取数组
           _attr.forEach(function(val,ind){
                li+="<option value='"+val+"'>";
                li+=val;
            li+="</option>"
        });
        li+="</select>"
        }
        li+='</li>';
        //把拼接好的li放到页面中
        $('#attr_list').html(li);
    });
   
       }

         
    });

          
      }
     else
      {
          //选择了 请选择，也就是没选
          
           $('#attr_list').html(''); //内容直接清空
          
      }

    


                

});
function addNewAttr(a){
   var li= $(a).parent();
   if($(a).text()=="+"){
       //clone不会clone事件，但是这里是直接写到dom上去的，所以这里可以用
       var newli=li.clone();
       newli.find('a').text('-');
       li.after(newli);
   }else{
       li.remove();//删除
   }
}
</script>


























<div id="footer"> 39期 </div>
</body>
</html>