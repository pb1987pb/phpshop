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

<!-- 搜索表单 -->
<div class="form-div">
    <form action="/index.php/Admin/Goods/lst" method="GET" name="searchForm" id="from">
		<P>
			商品名称：
			<input value="<?php echo I('get.gn'); ?>" type="text" name="gn" size="60" />
		</P>
                <P>
			商品品牌：
			<?php buildSelect('brand','brand_id','id','brand_name',I('get.brand_id')) ?>
		</P>
                <P>
			商品分类：
                        <?php $cateid = I('get.cateid'); ?>
			 <select name="cateid">
						<option value="">选择分类</option>
						<?php foreach ($parentData as $k => $v): ?>	
                                                <option <?php echo $v['id']==$cateid?'selected="selected"':'' ?> value="<?php echo $v['id']; ?>"><?php echo str_repeat('-', 8*$v['level']).$v['catename']; ?></option>
						<?php endforeach; ?>					
                                        </select>
                   
		</P>
		<P>
			价　　格：
			从<input value="<?php echo I('get.fp'); ?>" type="text" name="fp" size="8" />
			到<input value="<?php echo I('get.tp'); ?>" type="text" name="tp" size="8" />
		</P>
		<P>
			是否上架：
			<?php $ios = I('get.ios'); ?>
			<input type="radio" name="ios" value="" <?php if($ios == '') echo 'checked="checked"'; ?> /> 全部
			<input type="radio" name="ios" value="是" <?php if($ios == '是') echo 'checked="checked"'; ?> /> 上架
			<input type="radio" name="ios" value="否" <?php if($ios == '否') echo 'checked="checked"'; ?> /> 下架
		</P>
		<P>
			添加时间：
			从<input type="text" id="fa" name="fa" value="<?php echo I('get.fa'); ?>" size="20" />
			到<input type="text" id="ta" name="ta" value="<?php echo I('get.ta'); ?>" size="20" />
		</P>
		<p>
			排序方式：
		<?php $obdy = I('get.odby', 'add_desc'); ?>
			<input  type="radio" name="odby" value="add_desc" <?php if($obdy == 'add_desc') echo 'checked="checked"'; ?> /> 以添加时间降序
			<input  type="radio" name="odby" value="add_asc" <?php if($obdy == 'add_asc') echo 'checked="checked"'; ?> /> 以添加时间升序
			<input type="radio" name="odby" value="price_desc" <?php if($obdy == 'price_desc') echo 'checked="checked"'; ?> /> 以价格降序
			<input type="radio" name="odby" value="price_asc" <?php if($obdy == 'price_asc') echo 'checked="checked"'; ?> /> 以价格升序
		</p>
		<P>
			<input type="submit" value="搜索" />
		</P>
    </form>
</div>
<!-- 列表 -->
<div class="list-div" id="listDiv">
	<table cellpadding="3" cellspacing="1">
    	<tr>
            <th>商品名称</th>
             <th>所属品牌</th>
             <th>所属分类</th>
             <th>所属扩展分类</th>
            <th >市场价格</th>
            <th >本店价格</th>
            <th >商品描述</th>
            <th >是否上架</th>
            <th >是否放到回收站</th>
            <th >原图</th>
			<th width="130">操作</th>
        </tr>
		<?php foreach ($data as $k => $v): ?>            
			<tr class="tron">
				<td><?php echo $v['goods_name']; ?></td>
                                <td><?php echo $v['brand_name']?$v['brand_name']:'暂未设置'; ?></td>
                                  <td><?php echo $v['catename']?></td>
                                  <td><?php echo $v['ext_id']?></td>
				<td><?php echo $v['market_price']; ?></td>
				<td><?php echo $v['shop_price']; ?></td>
				<td><?php echo $v['goods_desc']; ?></td>
				<td><?php echo $v['is_on_sale']; ?></td>
				<td><?php echo $v['is_delete']; ?></td>
                                <?php if($v['sm_logo']):?>
                                <td><?php showImage($v['sm_logo']); ?></td>
                                <?php else: ?>
                                 <td>暂未设置图片</td>
				<?php endif; ?>

                         
		        <td align="center">
                            <a href="<?php echo U('goodnumber?id='.$v['id']); ?>" title="编辑">库存量</a> | 
		        	<a href="<?php echo U('edit?id='.$v['id']); ?>" title="编辑">编辑</a> |
	                <a href="<?php echo U('delete?id='.$v['id'].'&p='.I('get.p')); ?>" onclick="return confirm('确定要删除吗？');" title="移除">移除</a> 
		        </td>
	        </tr>
        <?php endforeach; ?> 
		<?php if(preg_match('/\d/', $page)): ?>  
        <tr><td align="right" id="page-table"  nowrap="true" colspan="99" height="30"><?php echo $page; ?></td></tr> 
        <?php endif; ?> 
	</table>
</div>

<script>
    $(':radio').click(function(){
        $('#from').submit();
    });
</script>


<div id="footer"> 39期 </div>
</body>
</html>