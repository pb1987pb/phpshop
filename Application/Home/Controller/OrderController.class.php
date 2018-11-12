<?php
namespace Home\Controller;
use Think\Controller;
class OrderController extends BaseController {
       // 购物车控制器
    
    
      //下订单页面
    public function add()
    {
         //在跳转到订单页面之前，需要判断是否携带了购物车id组合
        
          $ids=I('get.ids');   //这里有可能是 1 ，有可能是 1,2,3这样子的id组合
           if(!$ids)
          {
            $this->error('请勾选购物车商品在下单');
             exit;
         }
         
          // 传递了商品id ,那么就去购物车去查询
          $cartModel=D('cart');
          $cartData=$cartModel->cartList($ids); 

        
           // 订单里面要防止不能有下架的商品，也就是 
           //  $cartData 查询出来的数据不能有is_on_sale是否的数据，所有这下面必须筛选
          
        
         //筛选数据
         $cartModel-> filtCar($cartData,$ids);
            if(!$cartData)
           {  
               //没有查询出商品，这个是前端非法传递的id
             $this->error('订单非法商品');
             exit;
           }
           
		$this->assign(array(
                    'ids' => $ids,
                    'cartData' => $cartData,
		     '_page_title' => '订单确认页面',
		        '_page_keywords' => '订单确认页面',
			'_page_description' => '订单确认页面',
		));
		$this->display();
     
    }

  
  
       //  下单成功页面，这里会根据付款类型生成一个支付宝或者是微信的按钮
      // 在这里是生成的支付宝的按钮
    	public function order_success()
	{
		$btn = makeAlipayBtn(I('get.order_id'));
		// 设置页面信息
    	$this->assign(array(
    		'btn' => $btn,
    		'_page_title' => '下单成功',
    		'_page_keywords' => '下单成功',
    		'_page_description' => '下单成功',
    	));
    	$this->display();
	}
        
        // 支付宝返回信息的地址
        public function receive()
        {
            // 这里就需要调用支付宝的接口，来判断这个消息是否是支付宝发来的
            require('./alipay/notify_url');
        }
        
        	/**
	 * 支付成功之后设置为已支付的状态 
	 *
	 * @param unknown_type $orderId
	 */
	public function setPaid($orderId)
	{
		/**
		 * ************　更新定单的支付状态　＊＊＊＊＊＊＊＊＊＊＊＊＊／
		 */
		$this->where(array(
			'id' => array('eq', $orderId),
		))->save(array(
			'pay_status' => '是',
			'pay_time' => time(),
		));
		/************ 更新会员积分，一个积分一块钱 *******************/
		$tp = $this->field('total_price,member_id')->find($orderId);
		$memberModel = M('member');  // 因为如果用D生成模型，那么在修改字段时会调用这个模型的_before_update方法，但现在这个功能不需要调用这个这个方法，所以这里使用M生成父类模型这样就不会调用_before_update了
		$memberModel->where(array(
			'id' => array('eq', $tp['member_id']),
		))->setInc('jifen', $tp['total_pricd']);
	}
        
}