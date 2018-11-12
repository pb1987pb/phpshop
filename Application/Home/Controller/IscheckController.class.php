<?php
namespace Home\Controller;
use Think\Controller;
//ajax需要登录的时候，用这个控制器
class IscheckController extends AjaxController 
{
    
    
    
       //增加购物车里面的数量
           public function ajaxCarNum()
    {
         
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
         // ajax 下订单
    public function ajaxAdd()
    {
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
}