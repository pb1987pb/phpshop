<?php
namespace Home\Model;
use Think\Model;
class GoodCategoryModel extends Model 
{
        /**
         * 获取三层分类数据
         */
        public function getAllThreeCat()
        {
            $threeCateData=S('cataData');
            if(!$threeCateData){
                   $allData=$this->select();  // 获取所有的分类
            $result=array();// 最终需要的三级分类的数组
            foreach ($allData as $k => $v)
            {
                if($v['parent_id']==0)
                {
                    foreach($allData as $k1 => $v1)
                        {
                           if($v1['parent_id']==$v['id']){
                               
                               foreach($allData as $k2 => $v2)
                                   {
                                   if($v2['parent_id']==$v1['id']){
                                       $v1['children'][]=$v2;
                                   } 
                               }
                               $v['children'][]=$v1;
                           }
                           
                        }
                    $result[]=$v;
                    
                }
            }
            S('cataData',$result,86400); //设置缓存为一天
            return $result;
            }
            // 有缓存，那么就直接返回返回就可以了
            return $threeCateData;
        }
       
        /**
         * 
         * 首页里面获取楼层信息
         */
        public function getIndex()
        {
            
           $data= S('floorData');
            if(!$data){
            $goodModel=D('Goods');
            // 获取顶层分类的推荐到楼层分类
          $floorData=  $this->where(array(
               'parent_id' => array('eq',0),
                'is_floor' => array('eq','是')
            ))->select();
    foreach ($floorData as $k =>&$v){
        // 获取顶层分类下的 二级未推荐的楼层。
      $floorData[$k]['nofloor'] = $this->where(array(
               'parent_id' => array('eq',$v['id']),
                'is_floor' => array('eq','否')
            ))->select();
      // 获取顶层分类下的 二级推荐的楼层。
      $floorData[$k]['yesfloor'] = $this->where(array(
               'parent_id' => array('eq',$v['id']),
                'is_floor' => array('eq','是')
            ))->select();
      
           // 循环每个顶级分类下的 二级推荐楼层下的 8 件商品
       foreach($floorData[$k]['yesfloor'] as $k1=>$v1)
       {
           $ids= $goodModel->getAllid($v1['id']);
           
         
            $ids=implode(',',$ids);   // 这个为什么要转换，是数组下面，in数组不会报错，是空数组，下面的in会报错
          $floorData[$k]['yesfloor'][$k1]['children']= $goodModel
                  ->where(array(
                      'id' => array('in',$ids),
                       'is_on_sale' => array('eq','是'),
                  )
                   )->limit(8)-> select();

       }

      // 还要获取这个楼层下所有的品牌，获取品牌的思路：先取出所有楼层下的分类 id,商品id获取商品然后
      // 商品表连接品牌表获取到品牌
         
        $idArr= $goodModel->getAllid($v['id']);
            $idArr= implode(',',$idArr);
      $floorData[$k]['brands']=  $goodModel->alias('a')->field('distinct b.*')
                 ->where(array(
             'a.id'=>array('in',$idArr),
             'b.id'=>array('gt',0)
         ))->join('left join pan_brand b on b.id=a.brand_id')
              ->limit(9)-> select();
    }
    S('floorData',$floorData,86400);
        return $floorData;
            }
         
            return $data;
        
        
        }
        
        
        /**
         * 
         * @staticvar array $res
         * @param type $catid   类型id ,获取这个类型上面的所有的id数组
         * @return type
         */
        public function getPrevCat($catid)
        {
            static $res=array();
            $info=$this->field('id,catename,parent_id')->find($catid);
            
            $res[]=$info;
           if($info['parent_id']>0){
               $this->getPrevCat($info['parent_id']);
           }
           return $res;
           
        }
        
     
        
        /**
         * 
         * @param type $id  给一个分类的id
         * @return type  找到所有的它下面的分类id的数组，不包括自己的id
         */
        public function getChildren($id)
	{
		$data = $this->select();
		return $this->_children($data, $id);
	}
	private function _children($data, $parent_id=0, $isClear=TRUE)
	{
		static $ret = array();
		if($isClear)
			$ret = array();
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $parent_id)
			{
				$ret[] = $v['id'];
				$this->_children($data, $v['id'], FALSE);
			}
		}
		return $ret;
	}
}