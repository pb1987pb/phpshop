<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title><?php echo $_page_title; ?></title>
	<meta name="keywords" content="<?php echo $_page_keywords; ?>" />
	<meta name="description" content="<?php echo $_page_description; ?>" />
	<!-- 引入公共的CSS -->
	<link rel="stylesheet" href="/Public/Home/style/base.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/global.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/header.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/bottomnav.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/footer.css" type="text/css">
	<!-- 引入公共的JS -->
	<script type="text/javascript" src="/Public/Home/js/jquery-1.8.3.min.js"></script>
<!--	<script type="text/javascript" src="/Public/Home/js/header.js"></script>-->
</head>
<body>
	<!-- 顶部导航 start -->
	<div class="topnav">
		<div class="topnav_bd w990 bc">
			<div class="topnav_left">
				
			</div>
			<div class="topnav_right fr">
				<ul>
                                    <li id="loginMes"></li>
<!--                                    <?php if(session('m_id')):?>
					<li>您好，<?php echo session('m_username')?>欢迎来到京西！[<a href="<?php echo U('Member/logout')?>">退出</a>]  </li>
                                            <?php else: ?>
                                        <li>您好，欢迎来到京西！[<a href="<?php echo U('Member/login')?>">登录</a>] [<a href="<?php echo U('Member/regist')?>">免费注册</a>] </li>
                                        <?php endif;?>-->
					<li class="line">|</li>
					<li>我的订单</li>
					<li class="line">|</li>
					<li>客户服务</li>

				</ul>
			</div>
		</div>
	</div>
	<!-- 顶部导航 end -->
	<div style="clear:both;"></div>
	
	

<link rel="stylesheet" href="/Public/Home/style/cart.css" type="text/css">
<style>
     .quanxuan .all{line-height: 50px;}
     .quanxuan .all > div{float: left;}
 .quanxuan .all, .quanxuan .ca{float: left;} 
 .imgwrap{width: 37px;height: 37px;}
  .imgwrap .xian{}
  .imgwrap.cur .xian{display: none}
  .imgwrap.cur .yin{display: block}
   .imgwrap .yin{display: none;}
   .mycart tbody .imgwrap img{width: 37px;height: 37px;}
   .col0{width: 60px;}
</style>
	
	<!-- 页面头部 start -->
	       <!-- 页面头部 start -->
	<div class="header w990 bc mt15">
		<div class="logo w990">
			<h2 class="fl"><a href="/"><img src="/Public/Home/images/logo.png" alt="京西商城"></a></h2>
                        <?php if(mycar == 'mycar') $flow = 'flow1'; else if(mycar == 'myorder') $flow = 'flow2'; else $flow = 'flow3'; ?>
			<div class="flow fr <?php echo $flow;?>">
				<ul>
                                    <li class="<?php echo mycar=='mycar'?'cur':''?>">1.我的购物车</li>
					<li class="<?php echo mycar=='myorder'?'cur':''?>">2.填写核对订单信息</li>
					<li class="<?php echo mycar=='copmorder'?'cur':''?>">3.成功提交订单</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- 页面头部 end -->
	<!-- 页面头部 end -->
	
	<div style="clear:both;"></div>

	<!-- 主体部分 start -->
	<div class="mycart w990 mt10 bc">
		  <div class="quanxuan">
                <div class="all"> 
                    <div class="imgwrap">
                        <img src="/Public/Home/images/check02.png" class="xian"/>
                        <img src="/Public/Home/images/check01.png" class="yin"/>
                    </div><div>全选</div></div> 
                <h2 class="ca"><span>我的购物车</span></h2>
                <div style="clear:both"></div>
            </div>
		<table>
			<thead>
				<tr>
                                     <th class="col0"></th>
					<th class="col1">商品名称</th>
					<th class="col2">商品信息</th>
					<th class="col3">单价</th>
					<th class="col4">数量</th>	
					<th class="col5">小计</th>
					<th class="col6">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  foreach ($cartData as $k => $v): ?>
                                
                                <?php if($v['is_on_sale']=='否'): ?>
				<tr>
                                          <td class="col0">
                                              <div class="imgwrap shixiao" data-id="<?php echo $v['id']?>">
                                    失效
                    </div>
                                    </td>
					<td class="col1"><a href=""><?php showImage($v['mid_logo']); ?></a>  
					<strong><a href="<?php echo U('Goods/detail?id='.$v['goods_id']); ?>"><?php echo $v['goods_name']; ?></a></strong></td>
					<td class="col2"> 
						<?php foreach ($v['attr'] as $k1 => $v1): ?>
							<p><?php echo $v1['attr_name']; ?>：<?php echo $v1['attr_value']; ?></p>
						<?php endforeach; ?>
					</td>
					<td class="col3">￥<span><?php echo $v['price']; ?>元</span></td>
					<td class="col4"> 
						
                                                <span><?php echo $v['goods_number']; ?></span>
						
					</td>
					<td class="col5">￥<span><?php $xj = $v['price'] * $v['goods_number'];echo number_format($xj,2,".",""); ?></span></td>
					<td class="col6"><a href="javascript:;" class="del">删除</a></td>
				</tr>
                                <?php else: ?>
                                		<tr>
                                          <td class="col0">
                                              <div class="imgwrap" data-id="<?php echo $v['id']?>">  
                        <img src="/Public/Home/images/check02.png" class="xian"/>
                        <img src="/Public/Home/images/check01.png" class="yin"/>
                    </div>
                                    </td>
					<td class="col1"><a href=""><?php showImage($v['mid_logo']); ?></a>  
					<strong><a href="<?php echo U('Goods/detail?id='.$v['goods_id']); ?>"><?php echo $v['goods_name']; ?></a></strong></td>
					<td class="col2"> 
						<?php foreach ($v['attr'] as $k1 => $v1): ?>
							<p><?php echo $v1['attr_name']; ?>：<?php echo $v1['attr_value']; ?></p>
						<?php endforeach; ?>
					</td>
					<td class="col3">￥<span><?php echo $v['price']; ?>元</span></td>
					<td class="col4"> 
						<a href="javascript:;" class="reduce_num"></a>
						<input type="text" name="amount" value="<?php echo $v['goods_number']; ?>" class="amount"/>
						<a href="javascript:;" class="add_num"></a>
					</td>
					<td class="col5">￥<span><?php $xj = $v['price'] * $v['goods_number'];echo number_format($xj,2,".",""); ?></span></td>
					<td class="col6"><a href="javascript:;" class="del">删除</a></td>
				</tr>
                                <?php endif; ?>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="6">购物金额总计： <strong>￥ <span id="total">0.00</span></strong></td>
				</tr>
			</tfoot>
		</table>
		<div class="cart_btn w990 bc mt10">
			<a href="/" class="continue">继续购物</a>
                        <a href="javascript:;" id="jiesuan" class="checkout">结 算</a>
		</div>
	</div>
	<!-- 主体部分 end -->
          <script type="text/javascript" src="/Public/Home/js/layer-v3.0.3/layer/layer.js"></script>
         <script>
            $(function(){
	
	//减少
	$(".reduce_num").click(function(){
            changegoodscount(this,1);  
	});

	//增加
	$(".add_num").click(function(){
   
            changegoodscount(this,2);  
		
	});

	//直接输入
	$(".amount").blur(function(){
             changegoodscount(this,3);
	});
        
           
        //点击删除按钮
        $('.del').click(function(){
            //这里简单的提示是否删除    
           if(confirm('确定删除这个商品么')){
        changegoodscount(this,4);
               
           }
        });
        
        // 全选 和 反选择
        $('.all .imgwrap').click(function(){
          $(this).toggleClass('cur'); 
          if($(this).hasClass('cur'))
          {
              // 全部选中的效果
                  $('td .imgwrap:not(".shixiao")').addClass('cur');
                  getTotal();
          }else{
              // 全部反选的效果
                $('td .imgwrap').removeClass('cur');
                $("#total").text('0.00');
          }
        
        });
        //单个勾选效果
        $('td .imgwrap').click(function(){
            //自己本身样式改变
          $(this).toggleClass('cur');
          getTotal();
        isAllCheck();
        });
     
                
                // 点击结算订单效果
          $('#jiesuan').click(function(){
               
               var idarr=[];
              $('td .imgwrap.cur').each(function(k,v){
                  var id=$(v).data('id');
                  // id 大于0并且 数组里面没有这个值才增加
                  if(id>0 && idarr.indexOf(id) == -1){
                      idarr.push(id)
                  }
                  
              });
              
               if(idarr.length==0)
                {
                    alert('下订单前必须选择商品');
                    return false;
                     
                 }
              
              var idsstr=idarr.join(",");
              
              // 去下订单页面
          window.location.href='/index.php/home/Order/add/ids/'+idsstr;
          
          
       
            });
            
            
            
            
});

// 获取总金额
function getTotal()
{
    //总计金额
		var total = 0;
                //计算总金额，需要全面点击勾选了，就是有没有cur样式
                $('td .imgwrap.cur').each(function(){
                    total += parseFloat($(this).parent().parent().find('.col5 span').text());
                });
		$("#total").text(total.toFixed(2));
}

 // 点击加减和输入数字的时候这里我们都是需要ajax修改购物车数量的
  //后台改变商品数量，删除也是这个操作

 function changegoodscount(el,type) {
     
           //  获取到 数量 
		var amount = $(el).parent().find(".amount");
                var num=parseInt(amount.val());
                      if(type == 1 && num>1)
                          //减少的情况
                           num--;
                      else if(type == 2)
                          // 增加的情况
                           num++;
                        else if(type == 3){
                            // 直接修改数量的情况,num数量不能小于1
                            if(num<1){
                                num=1;
                                $(el).val(1);
                            }
                        }else if(type == 4)
                        {
                            //等于4在这里是直接删除,那么这里删除，我们直接赋值num为0
                            num=0;
                        }
             // ajax增加或者减少到数据库或者cookie
                // 获取这个商品的 goods_id ，goods_attr_ids，goods_number
                var dataobj=$(el).parent().parent().find('.imgwrap');
                var id=dataobj.data('id');
            $.ajax({
	type : "POST",
	url : "/index.php/Home/Cart/ajaxCarNum",
        data:{
            id:id,
             num:num
        },
	dataType : "json",
	success : function(data)
	{
            
            if(data.code == -1){
                //-1,就表示登录过期了，那么这里就要跳转到登录
                   window.location.href='/index.php/home/member/login';
            }
           else if(data.code==1){
                 //等于1就是成功
                 // 前端页面数据和金额改变的
                 if(type !=4){
                     //type不是4，那么就是 增加或者减少数量，或者修改数量
                     amount.val(num);
		var subtotal = parseFloat($(el).parent().parent().find(".col3 span").text()) * num;
		$(el).parent().parent().find(".col5 span").text(subtotal.toFixed(2));
                getTotal();
                 }else{
                     // type等于4就是直接删除
                     $(el).parent().parent().remove();
                     
                     isAllCheck();//判断删除商品之后，是否全选
                     getTotal();//重新计算总价钱
                 }
               
            }else{
                // data.code=0 就是不成功，不成功就是异常错误
                
               layer.msg(data.mes);
            }
	}
});
          
 }
 
 function isAllCheck(){
      // 判断全选是否自己自动选中 
      var leng=$('td .imgwrap').length;
          if(leng && leng==$('td .imgwrap.cur').length){
              $('.all .imgwrap').addClass('cur');
          }else{
              $('.all .imgwrap').removeClass('cur');
          }
 }
 

        </script>
  
	
	<div style="clear:both;"></div>
	<!-- 底部版权 start -->
	<div class="footer w1210 bc mt15">
		<p class="links">
			<a href="">关于我们</a> |
			<a href="">联系我们</a> |
			<a href="">人才招聘</a> |
			<a href="">商家入驻</a> |
			<a href="">千寻网</a> |
			<a href="">奢侈品网</a> |
			<a href="">广告服务</a> |
			<a href="">移动终端</a> |
			<a href="">友情链接</a> |
			<a href="">销售联盟</a> |
			<a href="">京西论坛</a>
		</p>
		<p class="copyright">
			 © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号 
		</p>
		<p class="auth">
			<a href=""><img src="/Public/Home/images/xin.png" alt="" /></a>
			<a href=""><img src="/Public/Home/images/kexin.jpg" alt="" /></a>
			<a href=""><img src="/Public/Home/images/police.jpg" alt="" /></a>
			<a href=""><img src="/Public/Home/images/beian.gif" alt="" /></a>
		</p>
	</div>
	<!-- 底部版权 end -->

</body>
</html>
<script>
    
    $.ajax({
	type : "GET",
	url : "/index.php/Home/Member/ajaxChkLogin",
	dataType : "json",
	success : function(data)
	{
            var mes='';
		if(data.code==1){
                    // 等于0表示登录成功
                 mes='您好，'+data.username+'欢迎来到京西！[<a href="<?php echo U('Member/logout')?>">退出</a>] ';
                }else{
                  mes='您好，欢迎来到京西！[<a href="<?php echo U('Member/login')?>">登录</a>] [<a href="<?php echo U('Member/regist')?>">免费注册</a>]';
                }
	$('#loginMes').html(mes);
	}
});
</script>