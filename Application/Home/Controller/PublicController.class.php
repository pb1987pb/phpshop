<?php
namespace Home\Controller;
use Think\Controller;
//不需要登录的时候，用这个控制器
class PublicController extends Controller 
{
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
    
     // 获取商品数量
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
    
}