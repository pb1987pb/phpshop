<?php
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model 
{
	protected $insertFields = array('goods_name','market_price','shop_price','goods_desc',
            'is_on_sale','is_delete','brand_id','category_id','type_id',
            'promote_price','promote_start_date','promote_end_date','is_new','is_hot','is_best','is_floor','sort_num');
	protected $updateFields = array('id','goods_name','market_price','shop_price','goods_desc',
            'is_on_sale','is_delete','brand_id','category_id','type_id',
            'promote_price','promote_start_date','promote_end_date','is_new','is_hot','is_best','is_floor','sort_num');
	protected $_validate = array(
		array('goods_name', 'require', '商品名称不能为空！', 1, 'regex', 3),
                array('category_id', 'require', '商品主分类不能为空！', 1, 'regex', 3),
               array('type_id', 'require', '商品类型不能为空！', 1, 'regex', 3),
		array('goods_name', '1,150', '商品名称的值最长不能超过 150 个字符！', 1, 'length', 3),
		array('market_price', 'require', '市场价格不能为空！', 1, 'regex', 3),
		array('market_price', 'currency', '市场价格必须是货币格式！', 1, 'regex', 3),
		array('shop_price', 'require', '本店价格不能为空！', 1, 'regex', 3),
		array('shop_price', 'currency', '本店价格必须是货币格式！', 1, 'regex', 3),
		array('is_on_sale', '是,否', "是否上架的值只能是在 '是,否' 中的一个值！", 2, 'in', 3),
		array('is_delete', '是,否', "是否放到回收站的值只能是在 '是,否' 中的一个值！", 2, 'in', 3),
	);
	public function search($pageSize = 10)
	{   
		/**************************************** 搜索 ****************************************/
		$where = array();
                //商品名，这个是随便搜索的，所以用like
                $gn=I('get.gn');
                  if($gn)
                      $where['a.goods_name']=array('like',"%$gn%");
                  //品牌,这个是下拉选择的，所以用 eq 等于
                  $b_id=I('get.brand_id');
                  if($b_id)
                       $where['a.brand_id']=array('eq',$b_id); 
                  //分类
                  $cateid=I('get.cateid');
                  if($cateid)
                  {
                  $idarr= $this->getAllid($cateid);
                  $where['a.id']=array('in',$idarr);
                  }
                  
                  //价钱,价钱最好是转换一下。float强制转换不符合的为 0
                   // 价钱是一个范围，用  between
                $fp=(float)I('get.fp');   //$fp=I('get.fp');    
                 $tp=(float)I('get.tp'); //$tp=I('get.tp');
              
                    if($fp && $tp)
                      $where['a.shop_price']=array('between',array($fp,$tp));
                     elseif ($fp) 
                       $where['a.shop_price']=array('egt',$fp);
                     elseif ($tp)
                          $where['a.shop_price']=array('elt',$tp);
                      //是否热卖，是radio，也必须用 eq ，等于的意思。
                 $ios=I('get.ios');
                       if($ios)
                           $where['a.is_on_sale']=array('eq',$ios); 
                 $fa=I('get.fa');
                 $ta=I('get.ta');
                        if($fa && $ta) 
                             $where['a.addtime']=array('between',array($fa,$ta));
                        elseif ($fa) 
                             $where['a.addtime']=array('egt',$fa);
                        elseif ($ta) 
                             $where['a.addtime']=array('elt',$ta);

                /***************** 排序 *****************/
		$orderby = 'addtime';      // 默认的排序字段 时间
		$orderway = 'desc';   // 默认的排序方式，降序，后面添加的商品放前面
		$odby = I('get.odby');
		if($odby)
		{
                        if ($odby == 'add_asc')
                                $orderway = 'asc';
			elseif ($odby == 'price_desc')
				$orderby = 'a.shop_price';
			elseif ($odby == 'price_asc')
			{
				$orderby = 'a.shop_price';
				$orderway = 'asc';
			}
		}
            
		/************************************* 翻页 ****************************************/
                       $count = $this->alias('a')->where($where)->count();
                  
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		$data['data'] = $this ->order("$orderby $orderway")
                        ->field('a.*,b.brand_name,c.catename,group_concat(distinct e.catename separator "<br/>") ext_id')
                        ->alias('a')
                        ->join('left join __BRAND__ b on a.brand_id = b.id
                                left join pan_good_category c on a.category_id = c.id
                                left join pan_good_cat d on a.id = d.good_id
                                left join pan_good_category e on d.category_id = e.id'
                                )
                        ->where($where)
                        ->group('a.id')
                        ->limit($page->firstRow.','.$page->listRows)
                        ->select();
            
		return $data;
	}
	// 添加前
	protected function _before_insert(&$data, $option)
	{     
            
		if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0)
		{
			$ret = uploadOne($_FILES['logo'], 'Goods', array(
				array(700, 700),
				array(500, 500),
				array(300, 300),
                            array(150, 150),
			));
			if($ret['ok'] == 1)
			{
				$data['logo'] = $ret['images'][0];
				$data['mbig_logo'] = $ret['images'][1];
                                $data['big_logo'] = $ret['images'][2];
				$data['mid_logo'] = $ret['images'][3];
				$data['sm_logo'] = $ret['images'][4];
			}
			else 
			{
				$this->error = $ret['error'];
				return FALSE;
			}
		}
                //这个是过滤富文本的，
               $data['goods_desc']=removeXSS($_POST['goods_desc']);
                $data['addtime']=date('Y-m-d H:i:s',time());
	}
	//添加商品后
     protected function _after_insert(&$data, $option)
	{
                $id = $data['id'];   // 添加之后的商品id
                //商品会员价格的添加
                $priceArr=I('post.price');
                 $priceModel=D('member_price');
                 foreach ($priceArr as $key => $value) {
                     $_value=(float)$value;
                     if($_value>0){
                         $priceModel->add(array(
                             'good_id'  =>   $id,
                             'level_id' =>   $key,
                             'price'    =>   $_value
                         ));
                     }
                 }
                 
                 //商品相册的增加
                 $phoneModel=D('good_phone');
                 if(isset($_FILES['pic'])){
                     foreach ($_FILES['pic']['error'] as $k=>$v){
                         if($v==0){
                           $siginpic=array(
                               'name' =>$_FILES['pic']['name'][$k],
                                'type' =>$_FILES['pic']['type'][$k],
                                'tmp_name' =>$_FILES['pic']['tmp_name'][$k],
                                'error' =>$v,
                               'size' =>$_FILES['pic']['size'][$k]
                           );
                            $ret = uploadOne($siginpic, 'Goods', array(
                                array(50, 50),
                                array(350, 350),
				array(650, 650)
			));
                            if($ret['ok']==1){
                                $phoneModel->add(array(
                                        'good_id' =>$id,
                                         'pic' =>$ret['images'][0],
                                         'sm_pic' =>$ret['images'][1],
                                         'mid_pic' =>$ret['images'][2],
                                         'big_pic' =>$ret['images'][3])
                                        );
                            }
                             
                         }
                     }
                 }
                 ////商品扩展分类的增加
                  $goodcatModel=D('good_cat');
                  $catArr=I('post.cat_id');
                  $catArr=array_unique($catArr);//去重复
                  foreach ($catArr as $k=>$v){
                      if($v){
                         $goodcatModel->add(array(
                             'good_id' =>$id,
                             'category_id' =>$v,
                         )); 
                      }
                  }
                  //商品属性的增加
                  $shangpinattrModel=D('shangpin_attr');
                     $attrmesArr=I('post.attrmes');
                    foreach ($attrmesArr as $k=>$v){
                        $v=array_unique($v);
                        foreach ($v as $k1=>$v1){
                            if($v1){
                         $shangpinattrModel->add(array(
                             'good_id' =>$id,
                             'attr_id' =>$k,
                             'attr_value' =>$v1,
                         )); 
                      }
                            
                        }
                        
                      
                  }
	
	}

      // 修改,修改属性这里其实有一个bug，商品的 type_id 属性不能修改
	protected function _before_update(&$data, $option)
	{
         $id = $option['where']['id']; 
 
		if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0)
		{
			$ret = uploadOne($_FILES['logo'], 'Goods', array(
				array(700, 700, 2),
				array(500, 500, 2),
				array(300, 300, 2),
                                array(150, 150, 2),
			));
			if($ret['ok'] == 1)
			{
				$data['logo'] = $ret['images'][0];
				$data['mbig_logo'] = $ret['images'][1];
                                $data['big_logo'] = $ret['images'][2];
				$data['mid_logo'] = $ret['images'][3];
				$data['sm_logo'] = $ret['images'][4];
			}
			else 
			{
				$this->error = $ret['error'];
				return FALSE;
			}
			deleteImage(array(
				I('post.old_logo'),
                                I('post.old_mbig_logo'),
				I('post.old_big_logo'),
				I('post.old_mid_logo'),
				I('post.old_sm_logo'),
	
			));
		}
                
                //修改商品之前先删除会员价格，在重新添加会员价格
                $priceModel=D('memberPrice');
                $priceModel->where(array('good_id' => array('eq',$id)))->delete();
     
                        $priceArr=I('post.price');
                 foreach ($priceArr as $key => $value) {
                     $_value=(float)$value;
                     if($_value>0){
                         $priceModel->add(array(
                             'good_id'  =>   $id,
                             'level_id' =>   $key,
                             'price'    =>   $_value
                         ));
                     }
                 }
                 
                     //商品相册的修改
                 $phoneModel=D('good_phone');
                 if(isset($_FILES['pic'])){
                     foreach ($_FILES['pic']['error'] as $k=>$v){
                         if($v==0){
                           $siginpic=array(
                               'name' =>$_FILES['pic']['name'][$k],
                                'type' =>$_FILES['pic']['type'][$k],
                                'tmp_name' =>$_FILES['pic']['tmp_name'][$k],
                                'error' =>$v,
                               'size' =>$_FILES['pic']['size'][$k]
                           );
                            $ret = uploadOne($siginpic, 'Goods', array(
                                array(50, 50),
                                array(350, 350),
				array(650, 650)
			));
                            if($ret['ok']==1){
                                $phoneModel->add(array(
                                        'good_id' =>$id,
                                         'pic' =>$ret['images'][0],
                                         'sm_pic' =>$ret['images'][1],
                                         'mid_pic' =>$ret['images'][2],
                                         'big_pic' =>$ret['images'][3])
                                        );
                            }
                             
                         }
                     }
                 }
                 //商品扩展分类的修改
                 //先删除所以的扩展分类在重新添加
                 //获取扩展分类信息
                $goodcatModel=D('good_cat');
                 $goodcatData=$goodcatModel->where(array('good_id' => array('eq',$id)))
                         ->delete();
                       $catArr=I('post.cat_id');
                        $catArr=array_unique($catArr);//去重复，扩展属性是可以增加的，可能添加上是一样的
                  foreach ($catArr as $k=>$v){
                      if($v){
                          //这里在增加的时候要判断是否有值，就是不能下拉选择的是 请选择
                         $goodcatModel->add(array(
                             'good_id' =>$id,
                             'category_id' =>$v,
                         )); 
                      }
                  }
                 // 商品属性的修改
                      $shangpinattrModel=D('shangpin_attr');
                     $attrmesArr=I('post.attrmes');
                     $idArr=I('post.aid');
                     $count=0;   // 这个是为了循环，id和属性是一对一的关系
                     
                    foreach ($attrmesArr as $k=>$v){
                     
                        foreach ($v as $k1=>$v1){
                     
                             // 这里我们就简单的判断一下，不搞那么复杂，因为后端是自己操作的
                               if($idArr[$count]) // 有id值那么就是以前有的，那么就修改，这里有两个方法
                               {
                                       
                                   // 1, 修改几个字段 或者其中的某个字段可以用  setField 方法
                                  $shangpinattrModel-> 
                                         where(array('id'=>array('eq',$idArr[$count])))
                                        ->setField('attr_value',$v1);  
                                  // 2,这种方法也可以，知道id,那么就强行修改字段
                   //    $shangpinattrModel -> execute('replace into p39_goods_attr values("'.$gaid[$_i].'","'.$v1.'","'.$k.'","'.$id.'")');
                                
//                                   $shangpinattrModel -> execute("replace into pan_shangpin_attr values('$idArr[$count]','$id','$k','$v1')");    
                            
                               }  else
                                   {
                                    if($v1) // 有值才会增加操作
                                    {
                                           $shangpinattrModel->add(array(
                                               'good_id' => $id,
                                               'attr_id' => $k,
                                               'attr_value'=>$v1 
                                           ));
                                    }
                               }
                            
                            
                            
//                              //  有id值就表示是以前有的值
//                            if($idArr[$count]) 
//                            {
//                                
//                                  // 这里是 自己写的，写了很多判断，就是为了去掉重复的
//                                
//                                if($v1){ //有提交具体的值，那么先判断这个值是否已经在数据库里面了
//                             $findresult =    $shangpinattrModel->
//                                         where(array(
//                                             'good_id'=>array('eq', $id),
//                                             'attr_id'=>array('eq',$k),
//                                             'attr_value'=>array('eq',$v1)
//                                             ))
//                                         ->select();
//                            
//                             
//                             if($findresult && $findresult[0]['id']!=$idArr[$count]){ 
//                                 //  这个是这个值已经在数据库的情况 ，什么都不做，不做修改
//                                 //dump($findresult[0]['id']);
// 
//                             }else{
//                                 // 数据库里面没有保存这个值，直接修改成这个值。
//                                 
//                                  $shangpinattrModel-> 
//                                         where(array('id'=>array('eq',$idArr[$count])))
//                                        ->setField('attr_value',$v1);  
//                             }
//                                   
//                                } 
//                                else { 
//                                   //如果是把以前的值设置是 请选择，也就是清空，是删除操作
//                                   //
//                                    //但是把属性值删除了，那么响应的库存也会影响。
//                                    
//                                        // 删除商品之前先删除库存量
//                                  $goodnumModel=D('good_number');
//        $goodnumModel->fetchSql(true)-> where(
//               array(
//                   'good_id'=>array('exp', "=$id  and find_in_set($id,attr_list)")
//               ))->delete();
//                                        $shangpinattrModel-> 
//                                         where(array('id'=>array('eq',$idArr[$count])))
//                                        ->delete();
//                                }
//                              
//                                
//                            }
//                            else {
//                             //没有id值，那么就是新增的，新增的也有几个情况
//                                if($v1){ //提交属性必须有值,没有值那就没必要去判断
//                                    
//                                        $findresult =    $shangpinattrModel-> 
//                                         where(array(
//                                             'good_id'=>array('eq', $id),
//                                             'attr_id'=>array('eq',$k),
//                                             'attr_value'=>array('eq',$v1)
//                                             ))
//                                         ->select();
//                                       
//                                      if(!$findresult){
//                                          // 不能查询出来就增加,能查询出来不做任何操作
//                                           $shangpinattrModel->add(array(
//                                               'good_id' => $id,
//                                               'attr_id' => $k,
//                                               'attr_value'=>$v1
//                                               
//                                           ));
//                                         
//                                      }  
//                                        
//                                }
//                                
//                                }
                            
                      
                       $count++;
                            
                        }
                        
                      
                  }
                 
                  // 这个是过滤富文本的
                 $data['goods_desc']=removeXSS($_POST['goods_desc']);
                
	}
	// 删除前
	protected function _before_delete($option)
	{
            
		$id = $option['where']['id'];   // 要删除的商品的ID
             
                //删除logo图片
		$images = $this->field('logo,mbig_logo,big_logo,mid_logo,sm_logo')
                        ->find($id);
		deleteImage($images);
                //删除会员价格
                  $priceModel=D('memberPrice');
                $priceModel->where(array('good_id' => array('eq',$id)))->delete();
                //删除相册图片
                $phoneModel=D('good_phone');
                //先删除本地上传的图片
                $picArr=$phoneModel->field('pic,sm_pic,mid_pic,big_pic')
                        ->where(array('good_id' => array('eq',$id)))->select();
            foreach ($picArr as $k => $v){
            deleteImage($v); 
        }
        //删除数据库相册图片
             $phoneModel->where(array('good_id' => array('eq',$id)))->delete();

             //删除扩展分类
             $goodcatModel=D('good_cat');
            $goodcatModel->where(array('good_id' => array('eq',$id)))->delete();
            
             //删除商品，先要删除商品属性。
                  $shangpinattrModel=D('shangpin_attr');
                $shangpinattrModel->where(array('good_id' => array('eq',$id)))->delete();   
                
                // 删除商品，先删除库存量
                 $goodnumberModel=D('good_number');
                   $goodnumberModel->where(array(
                  'good_id' => array('eq',$id)
              ))->delete();
	}
   
	/************************************ 其他方法 ********************************************/
        private function getAllid($cateid){
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
}