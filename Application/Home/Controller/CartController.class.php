<?php
namespace Home\Controller;
use Think\Controller;
class CartController extends BaseController {
       // 购物车控制器 
    public function lst()
    {
        // 设置页面中的信息,
        // 购物车列表记录
          $cartModel=D('cart');
         $cartData=$cartModel->cartList();
		$this->assign(array(
                        'cartData' => $cartData,
			'_page_title' => '购物车列表',
		        '_page_keywords' => '购物车列表',
			'_page_description' => '购物车列表',
		));
    	$this->display();
    }
    
 
  

   
}