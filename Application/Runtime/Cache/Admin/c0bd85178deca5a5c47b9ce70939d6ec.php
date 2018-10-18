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


<!-- 列表 -->
<div class="list-div" id="listDiv">
      <form enctype="multipart/form-data" action="/index.php/Admin/Goods/goodnumber/id/30.html" method="post">
	<table cellpadding="3" cellspacing="1">
    	<tr>
           <?php foreach($newshangpinattrData as $k=>$v): ?>
             
            <th ><?php echo $k ;?></th>
              <?php endforeach; ?>
              <th width="200">库存量</th>
			<th width="130">操作</th>
        </tr>
           <?php if($firstData): foreach($firstData as $k =>$v): $str=','.$v['attr_list'].','; ?>
         
	<tr>
           <?php foreach($newshangpinattrData as $k1=>$v1): ?>
           <td>
               <select name="attrs[]">
                     <option value="">请选择</option>
             <?php foreach($v1 as $k2=>$v2): if(strpos($str,$v2['id'])) $select = 'selected="selected"'; else $select = ''; ?>
              <option <?php echo $select; ?> value="<?php echo $v2['id'] ?>"><?php echo $v2['attr_value'] ?></option>
             <?php endforeach; ?>
                          </select>
 
                       </td>

              <?php endforeach; ?>
              
              <td>
                  <input type="text" value="<?php echo $v['number'];?>" name='nums[]'/> 
              </td>	
              <td>
                  <span  onclick="add(this)" class="add"><?php echo $k==0?"+":"-" ?></span>
              </td>
        </tr>
          <?php endforeach; ?>
                
        <?php else: ?>
        <tr>
           <?php foreach($newshangpinattrData as $k1=>$v1): ?>
           <td>
               <select name="attrs[]">
                     <option value="">请选择</option>
             <?php foreach($v1 as $k2=>$v2):?>
              <option  value="<?php echo $v2['id'] ?>"><?php echo $v2['attr_value'] ?></option>
             <?php endforeach; ?>
                          </select>
 
                       </td>

              <?php endforeach; ?>
              
              <td>
                  <input type="text"  name='nums[]'/> 
              </td>	
              <td>
                  <span  onclick="add(this)" class="add">+</span>
              </td>
        </tr>

         <?php endif;?>
        
        <tr style="text-align: center" id='tijiao' ><td>提交</td></tr>
	</table>
           </form>
</div>

<script>
$(function(){
  $('#tijiao').click(function(){
     $('form').submit();
  });
});
  function add(a){
  
         var tr= $(a).parent().parent();
   if($(a).text()=="+"){
       //clone不会clone事件，但是这里是直接写到dom上去的，所以这里可以用
       var newtr=tr.clone();
       newtr.find('.add').text('-');
       $('#tijiao').before(newtr);
   }else{
       tr.remove();//删除
   }
    }
</script>


<div id="footer"> 39期 </div>
</body>
</html>