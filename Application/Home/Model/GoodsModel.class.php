<?php
namespace Home\Model;
use Think\Model;
class GoodsModel extends Model 
{
    /**
     * 获取推荐商品，推荐产品也就是促销产品。
     */
    public function getPro($limit=5)
    {
        $today=date('Y-m-d H:i'); //当前时间
       $data= $this->where(array(
           'is_on_sale' => array('eq','是'),
            'promote_price'=>array('gt',0),
            'promote_start_date'=>array('elt',$today),
             'promote_end_date'=>array('egt',$today),
        ))->limit($limit)->order('sort_num asc')->select();
       return $data;
    }
   
    /**
     * 
     * @param type $recType   这个是筛选的类别，有3中，新品，热卖，精品
     * @param type $limit
     * @return type
     */
     public function getRec($recType,$limit=5)
    {
        
       $data= $this->where(array(
           'is_on_sale' => array('eq','是'),
            "$recType"=>array('eq','是'),     //这里注意必须使用双引号，单引号不能识别变量
        ))->limit($limit)->order('sort_num asc')->select();
       return $data;
    }
    
    /** 
     *    这个考虑了主分类，也考虑了扩展分类的情况 ，获取分类下的所有商品的id 
     */
    public function getAllid($cateid){
             //主分类的情况
                    $parentModel = D('GoodCategory');
		$children = $parentModel->getChildren($cateid);
                $children[]=$cateid;
                //主分类下的id 集合
                  $idArr=$this->field('id')->where(array('category_id'=>array('in',$children)))
                         ->select();
                
                  //  扩展分类下的id
                 $goodcatModel=D('good_cat');
                 $idArr2=$goodcatModel->field('distinct good_id id')->where(array('category_id'=>array('in',$children)))
                         ->select();
     
               $idArr=array_merge($idArr,$idArr2);
               $newidArr=array();//设置一个空数组
               foreach ($idArr as $k=>$v){
                   if(!in_array($v['id'],$newidArr))
                           $newidArr[]=$v['id'];
               }
               return $newidArr;
            
        }
        
            /**
             * 
             * @param type $id  浏览进去商品的id
             * @return type     返回的是整个的 浏览商品的记录
             */
           public function displayHistory($id)
         {
            //首先获取cookie的值,有值就反序列化成数组。
            $oldData=cookie('historyGood')?unserialize(cookie('historyGood')):array();
            
             array_unshift($oldData,$id); //先增加
             $oldData=  array_unique($oldData);  //去重，先增加在去重，可以保证后面看的永远更新
       
            //数组只需要前六个,多余6个，就把最后一个去掉
            if(count($oldData)>6){
                $oldData=array_slice($oldData,0,6); //从第0个索引开始，取6个值
            }
            // 数组存回cookie,保存一个月浏览记录有效
            cookie('historyGood',serialize($oldData),3600*24*30);
           
            
            $oldData=  implode(',', $oldData);
            // 解决 查询中的 in和结果不一致的问题
           $hisData= $this->where(array(
                'id' => array('in',$oldData),
                 'is_on_sale' => array('eq','是'),
            ))->order("field(id,$oldData)")->select();
                  return $hisData;
         }
         /**
          * 根据商品的id获取这个商品在本店的卖价，就是对比会员价，促销价，看这个商品的卖价
          * @param type $id 商品的id
          */
         public function getPrice($id)
         {
              // 1,首先，看这个商品在这个时间段是否有促销价格
              $today=date('Y-m-d H:i'); //当前时间
              // 获取促销价格
             $promote_price=$this->field('promote_price')
                     ->where(array(
                         'id'=>array('eq',$id),
                  'promote_price'=>array('gt',0),
            'promote_start_date'=>array('elt',$today),
             'promote_end_date'=>array('egt',$today),
             ))->find();
             // 获取商品本身的售价
             $normal_price=$this->field('shop_price')->find($id);
              
                
             // 2,从session里面获取会员级别信息
             $level=session('memberlevel');
             if($level){
               //登录的情况，去查询出来此商品相对于的会员等级的价钱
                 $memberpriceModel=D('member_price');
                $memberprice= $memberpriceModel->field('price')
                        ->where(array(
                     'good_id'=>array('eq',$id),
                     'level_id'=>array('eq',$level)
                 ))->find();
           
                // 能查询出来会员价格
                if($memberprice['price']){
                    // 有促销价，就比较促销价和会员价中小的，没有促销价，就会员价
            return  $promote_price['promote_price']? min($promote_price['promote_price'],$memberprice['price']): $memberprice['price'];
                    
                }
                
             }
             // 登录了没有查询出会员价格，那么也是比较促销价格和正常价格
             // 没有登录，那么基本就是直接促销价 或者正常价格
              return  $promote_price['promote_price']? min($promote_price['promote_price'],$normal_price['shop_price']): $normal_price['shop_price'];
    
             
         }
}