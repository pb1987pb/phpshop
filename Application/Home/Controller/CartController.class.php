<?php
namespace Home\Controller;
use Think\Controller;
class CartController extends Controller {
       // 购物车控制器
    
 

    
    // 前端点击商品ajax添加到购物车
        public function ajaxAdd()
    {

    		$model = D('Cart');
    		if($model->create(I('post.'), 1))
    		{
    			if($model->add())
    			{
                            //  加入购物车成功，顺便调下方法，查询购物车数量，返回这个数量
                            
                            $cartModel=D('cart');
                           $count=$cartModel->carCount();
                            
                             echo json_encode(array(
				'code' => 1,
                                 'count' => $count
			    ));
    				exit;
    			}
    		}
         echo json_encode(array(
				'code' => 0,
				'mes' =>$model->getError()
			));
                    
     
    }
    
    
    
    
    
    
    public function lst()
    {
        
        // 验证是否登录
         if(!session('m_id'))
        {
              //没有登录，那么就跳到登录页面，但是这里设置一个登录之后回来的页面,就是购物车页面
//             session('returnUrl',U('Cart/lst'));
             
             // 这里因为是ajax 跳转，所有保存到 cookie
             cookie('returnUrl',U('Cart/lst'));
             $this->redirect('member/login');
        }
        
        
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
    
     public function ajaxCarCount()
    {
         $cartModel=D('cart');
        $count=$cartModel->carCount();
      
        echo $count;
    }
    
    
    //鼠标滑动到头部购物车的时候，异步加载的购物车数据
    public function ajaxCarList()
    {
         $cartModel=D('cart');
        $data=$cartModel->cartList();
      
        echo json_encode($data);
    }
    
    // 购物车ajax 修改商品数量,删除也是这个操作,删除的操作前提也是必须要登录
     public function ajaxCarNum()
    {
         
           // 获取登录凭证
         $member_id=session('m_id');
                     // 验证是否登录，没有登录
         if(!$member_id)
        {

              //没有登录，那么就跳到登录页面，但是这里设置一个登录之后回来的页面,就是购物车页面   
             // 这里因为是ajax 跳转，所有保存到 cookie
             cookie('returnUrl',U('Cart/lst'));
              echo json_encode(array(
				'code' => -1,
				'mes' =>'登录已过期'
			));
              exit;
        }
         
                $num=I('post.num');//获取购物车商品数量
                $id=I('post.id');//获取购物车id
                $cartModel=D('cart');
               if($result=$cartModel->cartNum($num,$id))
                {
                    //修改或者删除操作成功就是返回的这个
                    echo json_encode(array(
				'code' => 1
			));
               }  
               else {
                         echo json_encode(array(
				'code' => 0,
				'mes' =>$cartModel->getError()
			));
               }
        
       
      
    }
   
}