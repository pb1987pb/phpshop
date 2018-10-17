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
        <form enctype="multipart/form-data" action="/index.php/Admin/Goods/edit/id/40.html" method="post">
            <input type='hidden' name='id' value="<?php echo $data['id']?>"/>
            <input type="hidden" name="old_logo" value="<?php echo $data['logo']; ?>" />
            <input type="hidden" name="old_mbig_logo" value="<?php echo $data['mbig_logo']; ?>" />
            <input type="hidden" name="old_big_logo" value="<?php echo $data['big_logo']; ?>" />
            <input type="hidden" name="old_mid_logo" value="<?php echo $data['mid_logo']; ?>" />
            <input type="hidden" name="old_sm_logo" value="<?php echo $data['sm_logo']; ?>" />
        	<!-- 基本信息 -->
            <table width="90%" class="tab_table" align="center">
            	<tr>
                    <td class="label">所在品牌：</td>
                    <td>
                    <?php buildSelect('brand', 'brand_id', 'id', 'brand_name',$data['brand_id']); ?>
                    </td>
                </tr>
                  <tr>
                    <td class="label">所属主分类：</td>
                    <td>
                   <select name="category_id">
						<option value="">选择主分类</option>
						<?php foreach ($parentData as $k => $v): ?>	
                                                <option <?php echo $v['id']==$data['category_id']?'selected="selected"':'' ?> value="<?php echo $v['id']; ?>"><?php echo str_repeat('-', 8*$v['level']).$v['catename']; ?></option>
						<?php endforeach; ?>					
                                        </select>
                    </td>
                </tr>
                         <tr>
                      <td class="label">所属扩展分类：<span id='add'>添加一个扩展分类</span></td>
                    
                   <?php if($goodcatData): ?>
                      <td class="catwrap">
                           <?php foreach ($goodcatData as $k1 => $v1): ?>
                        <select name="cat_id[]" class="cat">
						<option value="">选择扩展分类</option>
						<?php foreach ($parentData as $k => $v): ?>	
                                                <option <?php echo $v['id']==$v1['category_id']?'selected="selected"':'' ?>  value="<?php echo $v['id']; ?>"><?php echo str_repeat('-', 8*$v['level']).$v['catename']; ?></option>
						<?php endforeach; ?>					
                                        </select>
                          <?php endforeach; ?>
                    </td>
                      <?php else: ?>
                         <td class="catwrap">
                        <select name="cat_id[]" class="cat">
						<option value="">选择扩展分类</option>
						<?php foreach ($parentData as $k => $v): ?>	
                                                <option   value="<?php echo $v['id']; ?>"><?php echo str_repeat('-', 8*$v['level']).$v['catename']; ?></option>
						<?php endforeach; ?>					
                                        </select>
    
                    </td>
                     <?php endif; ?>
                </tr>
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" size="60" value="<?php echo $data['goods_name']; ?>"/>
                    <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td class="label">LOGO：<br>
                        <?php echo showImage($data['sm_logo']); ?>
                    </td>
                    <td><input type="file" name="logo" size="60" /></td>
                </tr>
                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="<?php echo $data['market_price']; ?>" size="20" />
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="<?php echo $data['shop_price']; ?>" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        
                        <input type="radio" name="is_on_sale" value="是" <?php if($data['is_on_sale']=="是") echo "checked='checked'"?>  /> 是
                        <input type="radio" name="is_on_sale" value="否" <?php if($data['is_on_sale']=="否") echo "checked='checked'"?>/> 否
                    </td>
                </tr>
                     <tr>
                         
                    <td class="label">是否删除：</td>
                    <td>
                       <input type="radio" name="is_delete" value="是"  <?php if($data['is_delete']=="是") echo "checked='checked'"?>/> 是
                        <input type="radio" name="is_delete" value="否" <?php if($data['is_delete']=="否") echo "checked='checked'"?>/> 否
                    </td>
                </tr>
                  <tr>
                    <td class="label">促销信息：</td>
                    <td>
                        
                        促销价格：￥<input type="type" name="promote_price" value="<?php echo $data['promote_price']?>"  /> 元<br/>
                        促销开始时间：<input type="text" id="sta" name="promote_start_date" class="test-item" value="<?php echo $data['promote_start_date']?>"/> <br/>
                        促销结束时间：<input type="text" id="end" name="promote_end_date" class="test-item" value="<?php echo $data['promote_end_date']?>"/> 
                    </td>
                </tr>
                   <tr>
                         
                    <td class="label">是否新品：</td>
                    <td>
                       <input type="radio" name="is_new" value="是"  <?php if($data['is_delete']=="是") echo "checked='checked'"?>/> 是
                        <input type="radio" name="is_new" value="否" <?php if($data['is_new']=="否") echo "checked='checked'"?>/> 否
                    </td>
                </tr>
                   <tr>
                         
                    <td class="label">是否热卖：</td>
                    <td>
                       <input type="radio" name="is_hot" value="是" <?php if($data['is_hot']=="是") echo "checked='checked'"?> /> 是
                        <input type="radio" name="is_hot" value="否" <?php if($data['is_hot']=="否") echo "checked='checked'"?>/> 否
                    </td>
                </tr>
                   <tr>
                         
                    <td class="label">是否精品：</td>
                    <td>
                       <input type="radio" name="is_best" value="是"  <?php if($data['is_best']=="是") echo "checked='checked'"?>/> 是
                        <input type="radio" name="is_best" value="否" <?php if($data['is_best']=="否") echo "checked='checked'"?>/> 否
                    </td>
                </tr>
                 <tr>
                         
                    <td class="label">是否推荐楼层：</td>
                    <td>
                       <input type="radio" name="is_floor" value="是"  <?php if($data['is_floor']=="是") echo "checked='checked'"?>/> 是
                        <input type="radio" name="is_floor" value="否" <?php if($data['is_floor']=="否") echo "checked='checked'"?>/> 否
                    </td>
                </tr>
                 <tr>
                         
                    <td class="label">排序字段：</td>
                    <td>
                       <input type="text" name="sort_num" value="<?php echo $data['sort_num']?>"  /> 
                      
                    </td>
                </tr>
            </table>
            <!-- 商品描述 -->
            <table style="display:none;" width="100%" class="tab_table" align="center">
            	<tr>
                    <td>
                        <textarea id="goods_desc" name="goods_desc" ><?php echo $data['goods_desc']?></textarea>
                    </td>
                </tr>
            </table>
            <!-- 会员价格 -->
            <table style="display:none;" width="90%" class="tab_table" align="center">
            	<tr>
                    <td>
                     <?php foreach($levelData as $k => $v): ?>
                    
                     <p><?php echo $v['level_name']; ?>：￥  <input style='padding-left:20px;' name="price[<?php echo $v['id']; ?>]" type='text' size="20"
                                                                  value="<?php echo $v['price']; ?>"></p>
                     <?php endforeach; ?>
                    </td>
                </tr>
            </table>
             <!-- 商品属性 -->
                 <table style="display:none;" width="90%" class="tab_table" align="center">
            	<tr>
                      
                    <td> 商品类型：<?php buildSelect('good_type', 'type_id', 'id', 'type_name',$data['type_id'])?></td>
                    
                </tr>
                	<tr>
                      
                    <td> 
                   
                        
                   <ul id='attr_list'>
                            <?php  $attrId=array(); foreach($attrmesDate as $k=>$v): if(in_array($v['attr_id'],$attrId)) $opt='-'; else{ $opt='+'; $attrId[]=$v['attr_id']; } ?>
                            <li>
                            <?php if($v['atrr_type']!=1):?>
                            <a href="javascript:;" onclick="addNewAttr(this);"><?php echo $opt;?></a>
                             <?php endif;?>
                            <?php echo $v['attr_name'];?>：
   <input type="hidden" name="aid[]" value="<?php echo $v['id'];?>"/>
                               <?php if($v['attr_input_type']==1):?>
                               <input type='text' name='attrmes[<?php echo $v["attr_id"];?>][]' value="<?php echo $v['attr_value']?>"/>
                             <?php elseif($v['attr_input_type']==3): ?>
                             <textarea name='attrmes[<?php echo$v["attr_id"];?>][]'>
<?php echo $v['attr_value']?>
  </textarea>
                           <?php elseif($v['attr_input_type']==2): ?>
                          <?php  $attr =explode("\r\n", $v['arrvalue']); ?>
                               <select name='attrmes[<?php echo$v["attr_id"];?>][]'>
                               <option value='' >请选择</option>
                               <?php foreach($attr as $k1=>$v1): if(trim($v1)==$v['attr_value']) $select = 'selected="selected"'; else $select = ''; ?>
                               <option  <?php echo $select; ?>  value='<?php echo $v1;?>'><?php echo $v1;?></option>
                                    <?php endforeach;?>
  </select>  
   
                             <?php endif;?>
                            </li>
                              <?php endforeach;?>
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
                        <ul id="ul_pic_list">
                           <?php foreach($phoneData as $k => $v): ?>
                                                           
                           <li><p class="shanchu" data-id="<?php echo $v['id']; ?>">删除</p>
                           <?php  showImage($v['mid_pic']);?></li>
                           <?php endforeach; ?>
                        </ul>
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

<!--时间组件-->
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
// 删除一张
$(".shanchu").click(function(){
	var id=$(this).data('id');
        var li=$(this).parent();
		$.ajax({
			type : "GET",
			url : "<?php echo U('ajaxDelPic', '', FALSE); ?>/id/"+id,
			success : function(data)
			{
				// 把图片从页面中删除掉
				li.remove();
			}
		});
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
           _attr.forEach(function(val,index){
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
       //去掉select的选中状态 ,在增加的时候本身就没有状态，所以增加不需要。
        newli.find('select').val("");
//       newli.find('option:selected').removeAttr("selected"); 这样子的也可以达到效果
   // 隐藏域中的id也不能赋值
   newli.find('input:hidden').val("");

   
       newli.find('a').text('-');
       li.after(newli);
   }else{
       // 点击了 “-” 号的情况
       //  这里面也有几个情况 ，没有id,那就是先添加的，删除了直接删除
       var id=li.find('input:hidden').val();
       if(!id){
           li.remove();//删除
       }else{
        // 有id值那么就是开始就有的，那么删除就必须要ajax删除了。
        if(confirm('如果删除了属性，那么相应的库存量数据也会被删除，确定删除么')){
              $.ajax({
            url:"<?php echo U('ajaxDel?good_id='.$data['id'],'',false)?>/id/"+id,
            success:function(){
                li.remove();//删除
                
                
            }
            
            
        });
        }
      
       }
       
   }
}
</script>


























<div id="footer"> 39期 </div>
</body>
</html>