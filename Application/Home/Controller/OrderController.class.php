<?php
namespace Home\Controller;
use Think\Controller;
class OrderController extends Controller {
       // 购物车控制器
    
    
      //下订单页面
    public function add()
    {
         //在跳转到订单页面之前，需要判断是否携带了购物车id组合和登录
        
          $ids=I('get.ids');   //这里有可能是 1 ，有可能是 1,2,3这样子的id组合
           if(!$ids)
          {
            $this->error('请勾选购物车商品在下单');
             exit;
         }
        $m_id=session('m_id');
    
        if(!$m_id)
        {
            //没有登录，那么就跳到登录页面，但是这里设置一个登录之后回来的页面
            
              //这里需要带参数,因为订单页面是必须设置 购物车 id参数的
               cookie('returnUrl',U('Order/add?ids='.$ids));   
               redirect(U('Member/login'));
        }

          // 传递了商品id,也登陆了 ,那么就去购物车去查询
          $cartModel=D('cart');
          $cartData=$cartModel->cartList($ids); 

           if(!$cartData)
           {  
               //没有查询出商品，这个是前端非法传递的id
             $this->error('购物车非法商品');
             exit;
           }
           
    
           // 订单里面要防止不能有下架的商品，也就是 
           //  $cartData 查询出来的数据不能有is_on_sale是否的数据，这个可以在前端筛选
           // 让这数据不显示
           
          //  查询所有收货地址
               $addressModel=D('address');
           $addressData=$addressModel->where(array(
               'member_id' => array('eq',$m_id)
           ))->select();
    
           
		$this->assign(array(
                    'ids' => $ids,
                    'addressData' =>$addressData,
                    'cartData' => $cartData,
		     '_page_title' => '订单确认页面',
		        '_page_keywords' => '订单确认页面',
			'_page_description' => '订单确认页面',
		));
		$this->display();
     
    }

    public function ajaxAdd()
    {
        // 获取登录凭证
         $member_id=session('m_id');
         
         if(!$member_id)
        {

              //没有登录，那么就跳到登录页面，但是这里设置一个登录之后回来的页面,
              // 那么这里我们就调转到订单页面 ,保存到 cookie

              cookie('returnUrl',U('Order/add?ids='.I('post.ids')));
              echo json_encode(array(
				'code' => -1,
				'mes' =>'登录已过期'
			));
              exit;
        }
        
        
     echo json_encode(array(
				'code' => 0,
				'mes' =>json_encode(I('post.'))
			));
        
         exit;
         		$model = D('order');
    		if($model->create(I('post.'), 1))
    		{
    			if($order_id=$model->add())
    			{
 
                                echo json_encode(array(
				'code' => 1,
				'order_id' =>$order_id
			));
                                exit;
    			}
    		}

                echo json_encode(array(
				'code' => 0,
				'mes' =>$model->getError()
			));
        
    }
     public function pay()
     {
         dump(I('get.order_id'));
         exit;
     }
     
    
}