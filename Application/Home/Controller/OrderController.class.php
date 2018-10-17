<?php
namespace Home\Controller;
use Think\Controller;
class OrderController extends Controller {
       // 购物车控制器
    
    
      //下订单
    public function add()
    {
        //在跳转到订单页面之前，需要判断是否登录
        $m_id=session('m_id');
  
     
        if(!$m_id)
        {
            //没有登录，那么就跳到登录页面，但是这里设置一个登录之后回来的页面
            
              //这里需要带参数,因为订单页面是必须设置 购物车 id参数的
               cookie('returnUrl',U('Order/add?ids='.$ids));   
               redirect(U('Member/login'));
        }


         if(IS_POST)
    	{
               dump(I('post.'));
            exit;
    		$model = D('order');
    		if($model->create(I('post.'), 1))
    		{
    			if($order_id=$model->add())
    			{
 
    				//下单成功，就直接跳转到支付页面
                            redirect(U('pay?order_id='.$order_id));
    				exit;
    			}
    		}
    		$this->error('添加失败！原因：'.$model->getError());
    	}
           
                   
         
            $ids=I('get.ids');   //这里有可能是 1 ，有可能是 1,2,3这样子的id组合
           if(!$ids)
          {
            $this->error('请勾选购物车商品在下单');
             exit;
         }
          // 传递了商品id ,那么就去购物车去查询
          $cartModel=D('cart');
          $cartData=$cartModel->cartList($ids); 
           
          
          
          
           if(!$cartData)
           {  
               //没有查询出商品，这个是前端非法传递的id
             $this->error('购物车非法商品');
             exit;
           }
           
           // 这个里面有可能非常传递了
           
           
           
           
           
           // 订单里面要防止不能有下架的商品，也就是 
           //  $cartData 查询出来的数据不能有is_on_sale是否的数据，这个可以在前端筛选
       
            // 这里有一个对下架id的筛选，以后再做
           
           
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

     public function pay()
     {
         dump(I('get.order_id'));
         exit;
     }
     
    
}