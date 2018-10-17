<?php
namespace Home\Model;
use Think\Model;
class OrderModel extends Model 
{
         // 下订单的时候接受的数据 ,是 下单时候接受到的
	protected $insertFields = array('ids','pay_type','cur_name','cur_tel','cur_province','cur_city','cur_area','cur_address','beizhu');
        
//	protected $updateFields = array('id','password','repassword');

        
	protected $_validate = array(
                array('ids', 'require', '订单中必须有商品！', 1, 'regex', 3),
                array('pay_type', 'require', '必须选择付款方式！', 1, 'regex', 3),
            array('cur_name', 'require', '收货人为空！', 1, 'regex', 3),
            array('cur_tel', 'require', '收货人电话号码为空！', 1, 'regex', 3),
             array('cur_province', 'require', '必须选择省份！', 1, 'regex', 3),
             array('cur_city', 'require', '必须选择市区！', 1, 'regex', 3),
             array('cur_area', 'require', '必须选择区！', 1, 'regex', 3),
             array('cur_address', 'require', '必须填写详细地址', 1, 'regex', 3),
              
	);
        
      	// 添加订单前
	protected function _before_insert(&$data, &$option)
	{          
            
          
		// 添加订单前的检查工作
            // 1, 检查是否登录，只有登录才能下订单
            //这里必须再次检查session，因为即使前面跳转到这个页面检查了一次，但是可能很长时间没操作，导致下单的时候session丢失
            // 那么这个检查是必须的 。
            $m_id=session('m_id');
            if(!$m_id)
            {
                $this->error="未登录不能下单";
                return FALSE;
            }
                
            // 2，检查订单里面是否有商品,有商品才能下订单
            // 这里要根据传过来的id集合，从购物车查询商品数据
            
          $option['ids'] = $ids=I('post.ids');
            $cartModel=D('cart');

            // 这个数据是要传递到下面的增加之后的钩子函数里面的，所以上面的方法里面是需要 引用传递的。
            
         $option['goods'] =$goods=$cartModel->cartList($ids);
         
             // 这里我们还必须筛选一遍，下架的商品是不能再购物车里面的
           
      
          
         
            if(!$goods)
            {
                // 没有找到任何商品
                $this->error="未选中任何商品";
                return FALSE;
            }
 
            
            
            // 高并发的抢单，这里就要设定一个 锁 机制 ,为了保证这个锁是全局都可用，不至于这个方法用完了就释放，我们用对象属性
            // 来存储这个锁
            $this->lock=  fopen('./order.lock'); // 存储锁
            flock($this->lock,LOCK_EX);// 开始这个锁，LOCK_EX 表示排他锁
            
            
            // 3,最后有商品就检查库存
            $goodnumberModel=D('good_number');
            $total_price=0;//设定一个总价
         
            foreach ($goods as $k=>$v)
            {
                $total_price+=$v['price']*$v['goods_number']; //价钱累加
                // 商品总的库存量
                $num=$goodnumberModel->fetchSql(true) ->field('number')->where(array(
                    'good_id'=>array('eq',$v['goods_id']),
                    'attr_list'=>array('eq',$v['goods_attr_ids'])
                ))->find();
              
                
                // 总的库存少于购物车的商品数量
                if($num['number']<$v['goods_number'])
                {
//                       dump($num['number']);dump($v['goods_number']);
                      $this->error=$v['goods_name']."库存量不足";
                        return FALSE;
                }
                
                // 通过了上面的3个检查之后，那么基本就可以下单了，补充其他字段
                $data['addtime']=  time();
                $data['total_price']=$total_price;
                $data['member_id']=$m_id;
                
                // 从这里开始插入订单基本信息，那么在这里就要开启事务.
                //  为了确定三张表的操作都能成功：订单基本信息表，订单商品表，库存量表
                // 开启事务的前提是相关表必须使用innodb引擎。
                $this->startTrans();  
            }
            
	}
	
        // 添加订单后，那么订单这里我们需要做3个事情，
        // 第一个添加订单商品，
        // 第二个减少相应的库存
        // 第三个 删除购物车中相应的商品
	protected function _after_insert($data, $option)
	{
             $id = $data['id'];
             $ordergoodModel=D('order_goods');
             $goodnumberModel=D('good_number');
             $cartModel=D('cart');
             foreach ($option['goods'] as $k => $v)
             {
                $ret= $ordergoodModel->add(array(
                     'order_id'=>$id,
                     'goods_id'=>$v['goods_id'],
                     'goods_attr_id'=>$v['goods_attr_ids'],
                     'goods_number'=>$v['goods_number'],
                     'price'=>$v['price']
                 ));
                 //  这个开始了事务，那么必须对每个插入数据库进行验证，失败了就回滚事务
                if(!$ret)
                {
                    $this->rollback();
                    $this->erroe="插入订单表商品信息失败";
                    return FALSE;
                }
                
                 // 修改库存，也就是减少相应的库存
                 
               $reduce=  $goodnumberModel->where(array(
                     'good_id' => array('eq',$v['goods_id']),
                     'attr_list' => array('eq',$v['goods_attr_ids'])
                 ))->setDec('number',$v['goods_number']);
               if($reduce===FALSE)
               {
                   // 这里就是修改库存失败
                    $this->rollback();
                    $this->erroe="修改库存量失败";
                    return FALSE;
               }
                 
             }
             // 所有操作都成功，就是这三张表都成功，就提交事务
             $this->commit();
             
             
             //这里 订单下好了，减少了库存，那么就主动释放这个锁
             flock($this->lock, LOCK_UN);
             fclose($this->lock);
             
             
          //删除掉购物车里面的选择下单的商品
        $cartModel->where(array(
           'member_id' => array('eq', session('m_id')),
            'id' => array('in',$option['ids'])
        ))-> delete();
             
	}
	/************************************ 其他方法 ********************************************/
}