<?php
namespace Home\Model;
use Think\Model;
class CartModel extends Model 
{ 
    // 购物车模型
     // 增加到购物车需要接受的字段 ,goods_attr_ids 这个属性参数可以没有
	protected $insertFields = array('goods_id','goods_attr_ids','goods_number');
        
        //修改购物车接收的字段，这里我们做的项目只允许修改数量
        protected $updateFields = array('id','goods_number');
        
        protected $_validate = array(
                array('goods_id', 'require', '必须选择商品！', 1, 'regex', 3),
                array('goods_number', 'check_kucun', '商品库存量不足！', 1, 'callback',3),
             
	);
        // 下面这个参数里面一定要写参数，参数就是第一个字段
        public function check_kucun($goods_number)
        {
            $good_id=I('post.goods_id');//表单隐藏域中获取到的商品的id
            $ids=I('post.goods_attr_ids');//商品属性组合id  ,这里有可能是没有属性的，得到的是''
           
           // 先排序 ,这个一定要先排序一下，属性顺序以错了就查询不出来库存量。
            //  因为库存量本身就是按照id的排序来存储的
            sort($ids,SORT_NUMERIC);
            
            //这里要注意，没有属性的时候，后面impode返回的是null，这里string强制
            //转换一下就是返回的是 空字符串,那么下面就可以查询出来
            
            $idStr=(string)implode(',', $ids);
          
            $goodnumberModel=D('good_number');
          
        $this->kucun=  $kcnum=  $goodnumberModel->field('number')
                  -> where(array(
                'good_id' => $good_id,
                'attr_list' => $idStr
            ))->find();
        
            return $kcnum['number'] >= $goods_number;
        }
        //这里因为要判断是否登录之后加入数据库还是登录前加入cookie，所以这个方法需要重写
        public function add()
        {
           
            $uid=session('m_id');// 获取登录人session
            
            $ids=I('post.goods_attr_ids');//商品属性组合id ,这个有可能是null
           // 先排序 ,这个一定要先排序一下，属性顺序以错了就查询不出来库存量。
            //  因为库存量本身就是按照id的排序来存储的
               sort($ids,SORT_NUMERIC);
            $idStr= (string)implode(',', $ids);
            
            // 下面这个是很重要的，因为，一旦下面用了
            $firnum=$this->goods_number; 
      
            if($uid)
            {
                //登录，先查询一下购物车是否已经有这个商品的数量，有就直接增加数量，没有就增加到数据库
              $has= $this->where(array(
                      'goods_id' =>array('eq',$this->goods_id) ,
                'goods_attr_ids' => array('eq',$idStr),
                    'member_id' => array('eq',$uid),
                ))->find();
  
               if($has)
               {
                   //已经有库存 , setInc 是直接对某个字段进行增加操作,
                   //那么这里有一个问题，如果能查询数据，上面查询出来的find会对提交的字段进行覆盖，所以这里我们‘
                   //  必须在查询前接受需要修改的 goods_number 字段

                     // 在这个项目里面我们先简单粗暴的处理，直接增加到购物车
                   $result = $this->where(array(
                      'id' =>array('eq',$has['id'])
                ))->setInc('goods_number',$firnum); 
                   
                   
               }  else {
                   // 在数据库里面没有查询到这个库存，那么就直接增加到数据库
                   //那么这里就调用父类的add方法，加到数据库
         
                    $result= parent::add(array(
                'goods_id' => $this->goods_id,
                'goods_attr_ids' => $idStr,
                  'goods_number' => $this->goods_number,
                   'member_id' => $uid,
            ));
                     
               }
               
                    if($result != FALSE)
                       return TRUE;
                   else
                   {
                       $this->error="购物车添加到数据库失败";
                       return FALSE;
                   }
               
               
            } 
            else 
                {
                  //没有登录,我们在购物车里面存储的是一个一维数组：类似 
                  // '商品id-属性id'=>购买数量
                //首先获取cookie的值,有值就反序列化成数组。
            $shops=cookie('shopcar')?unserialize(cookie('shopcar')):array();
            // 先判断cookie里面有不有这个已经存储的商品的数量
            $key= $this->goods_id.'-'.$idStr;
            if($cookienum=$shops[$key])
            {
                //这里也是购物车的增加，也要判断库存量,在这里我们也是简单粗暴的增加，我们不去判断库存量
                    $shops[$key]=$cookienum+$firnum;
              
            }  else {
                $shops[$key]=$firnum;
            }
            //购物车存储到cookie，保存一个月
             cookie('shopcar',serialize($shops),3600*24*30);
               return true;
                }
              
            
        }
        
        /**
         * 登录之后把cookie的数据移动到数据库中
         */
         public function moveDataToDb()
         {
             
             $member_id=session('m_id');
             
             $shops=cookie('shopcar')?unserialize(cookie('shopcar')):array();
             foreach ($shops as $k => $v)
             {
               $arr=explode('-',$k);
               $goodid=$arr[0];
               $attrids=$arr[1];
               // 查找当前数据库中有没有这个数据
                $has= $this->where(array(
                      'goods_id' => array('eq',$goodid),
                'goods_attr_ids' => array('eq',$attrids),
                     'member_id' => array('eq',$member_id)
                ))->find();
                if($has){
                    //已经有这个数据了就增加这个数量字段
                       $this->where(array(
                      'id' =>array('eq',$has['id'])
                ))->setInc('goods_number',$v); 
                }
                else 
                {
                    //没有这个数据，那么就直接调用父类的add方法，不能调用自己的，因为自己的是重写的了。
                      parent::add(array(
                'goods_id' => $goodid,
                'goods_attr_ids' => $attrids,
                  'goods_number' => $v,
                   'member_id' => $member_id,
            ));
                }
             }
             //最后清空这个cookie
            cookie('shopcar',null);
         }
         
         
           /**
            *  获取购物车商品的数量
            */
          public function carCount()
          {
              $member_id=session('m_id');
              if($member_id)
                  {
               $count=$this->where(array(
                   'member_id'=>array('eq',$member_id)
               ))->count();   
               
              }  else {
                  //没有登录，那么就从cookie里面获取,这个获取的是一个 一维数组，那么就转换为
                  //  从数据库查询出来的那种二维数组
                  $arr=cookie('shopcar')?unserialize(cookie('shopcar')):array();
                  $count= count($arr);
                  
              }
              return $count;
          }
         
         
         /**
          *   获取购物车中的数据信息,没有传递id就是获取购物车所有的信息，传递了id就是获取那几个选取的信息
          */
         public function cartList($ids="")
         {
              $member_id=session('m_id');
              if($member_id)
                  {
 
                  // 购物车里面显示的数据 ,购物车里面应该是可以显示下架的商品
                  $where=array(
                   'member_id'=>array('eq',$member_id)
               );
                  if($ids)
                  {
                    // 订单里面显示的商品数据，传递了id ,但是订单表里面不能 有 已经下架的商品出现
                    $where['id']=array('in',$ids);
                  }
                  
               $data=$this->where($where)->select();   
               
   
               
              }  else {
                  //没有登录，那么就从cookie里面获取,这个获取的是一个 一维数组，那么就转换为
                  //  从数据库查询出来的那种二维数组
                  $arr=cookie('shopcar')?unserialize(cookie('shopcar')):array();
                  $data=array();
                  foreach ($arr as $k =>$v){
                      $arr=explode('-',$k);
               $goodid=$arr[0];
               $attrids=$arr[1];
                     $data[]=array(
                          'goods_id' => $goodid,
                'goods_attr_ids' => $attrids,
                  'goods_number' => $v
                     ); 
                  }
                  
              }
              // 获取到这些信息还不够，商品本身信息和属性的信息都还没查询出来。
            
              $goodModel=D('goods');
              $shangpinattrModel=D('shangpin_attr');
              foreach ($data as $k => $v)
              {
                  //查询出商品信息
                $goodData=  $goodModel->where(array(
                      'id' =>array('eq',$v['goods_id'])
                  ))->find();
                 // 获取到的内容存回这个二维数组
                $data[$k]['goods_name']=$goodData['goods_name'];
                $data[$k]['mid_logo']=$goodData['mid_logo'];
                 $data[$k]['is_on_sale']=$goodData['is_on_sale'];   // 是否上架
                // 计算实际的购买价格
                 $data[$k]['price']=$goodModel->getPrice($v['goods_id']);
                 //根据属性id计算出商品的属性名称和属性值，
                 
                 if($v['goods_attr_ids'])
                 {
                   // 有属性的情况下就来查询相应的属性信息。
                   $data[$k]['attr'] = $shangpinattrModel->alias('a')->field('a.*,b.attr_name')
                         ->join('left join pan_good_attr b on b.id =a.attr_id')
                         ->where(array(
                     'a.id' => array('in',$v['goods_attr_ids'])
                 ))->select();
                 }
          
              }
              return $data;
         }
         
         //购物车修改数量,这里包含了删除商品的代码
         public function cartNum($num,$id)
         {
             if($num<0)
             {
                 $this->error="商品数量必须大于0";
                 return FALSE;
             } 
                 //  查询到这个商品是否删除，要不然的修改数量没意义
              $has= $this->where(array(
                   'id' =>array('eq',$id),
                  'is_delete' => array('eq','否')
                ))->find();
                 if($has)
                 {
                     //有这个商品，直接去数据库修改这个商品数量
                      //$num等于0，就是删除操作
                     if($num==0){
                        
                         if($this->delete($has['id']) !== FALSE)
                           return true;
                       else {
                            $this->error="删除操作异常";
                            return FALSE;
                       }
                     }
                     // $num不等于0，那么就是大于0，就是修改操作
                           $this->where(array(
                      'id' =>array('eq',$has['id'])
                ))->setField('goods_number',$num); 
                return true;
                 } 
                    // 登录没有查询到商品或者没登录查询到商品都会是非法商品
              $this->error="非法商品";
                 return FALSE;
         }
         
}