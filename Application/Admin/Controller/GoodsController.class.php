<?php
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends BaseController
{
    public function add()
    {
    
    	if(IS_POST)
    	{
//            dump(I('post.'));
//            exit;
    		$model = D('Goods');
    		if($model->create(I('post.'), 1))
    		{
    			if($id = $model->add())
    			{
    				$this->success('添加成功！', U('lst'));
    				exit;
    			}
    		}
    		$this->error('添加失败！原因：'.$model->getError());

    	}

		// 设置页面中的信息
             //获取会员级别
        $levelModel=D('memberLevel');
       $levelData=$levelModel->field('id,level_name')->order('jifen_bottom asc')-> select();
       
           //获取主分类信息
             $parentModel = D('GoodCategory');
		$parentData = $parentModel->getTree();
       
		$this->assign(array(
                         'parentData'=>$parentData,
                        'levelData' => $levelData,
			'_page_title' => '添加商品',
			'_page_btn_name' => '商品列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }
    public function edit()
    {
    	   $id = I('get.id');
           
           $model = D('Goods');
    	if(IS_POST)
    	{
//    
    		if($model->create(I('post.'), 2))
    		{       
    			if($model->save() !== FALSE)
    			{
    				$this->success('修改成功！', U('lst'));
    				exit;
    			}
    		}
    		$this->error('修改失败！原因：'.$model->getError());
    	}
     
 
    	$data = $model->find($id);
       
              //获取会员价格级别信息
        $levelModel=D('memberLevel');
      $levelData=$levelModel->alias('a')
              ->join('left join pan_member_price b on (b.level_id=a.id and b.good_id='.$id.')')
              ->field('a.id,a.level_name,b.price')
           ->order('a.jifen_bottom asc')
              ->select();

       
       // 查询出当前商品所有的相册信息
           $phoneModel=D('good_phone');
           $phoneData=$phoneModel->field('id,mid_pic')
                   ->where(array('good_id' => array('eq',$id)))
                   ->select();
           
           //获取主分类信息
             $parentModel = D('GoodCategory');
		$parentData = $parentModel->getTree();
           
            //获取扩展分类信息
                $goodcatModel=D('good_cat');
                 $goodcatData=$goodcatModel->field('category_id')
                         ->where(array('good_id' => array('eq',$id)))
                         ->select();
                  
                 //  获取商品属性信息 ,这样子开始是不行的 ，这样子是没有办法获取到后来的增加的
//                    $shangpinattrModel=D('shangpin_attr');
//                     $attrmesDate=$shangpinattrModel
//                             ->field('a.*,b.atrr_type,b.attr_input_type,b.attr_name,b.attr_value arrvalue')
//                             ->alias('a')
//                             ->join('left join pan_good_attr b on b.id=a.attr_id')
//                             ->order('a.attr_id asc')
//                             ->where(array(
//                         'good_id'=>array('eq',$id)
//                     ))->select();

                    //先取出所有的 本商品 本类型的 属性
                    $goodAttrModel=D('good_attr');
                 $attrmesDate= $goodAttrModel->
                         field('a.id attr_id,a.attr_name,a.atrr_type,a.attr_value arrvalue,a.attr_input_type,b.attr_value,b.id')->
                            alias('a')->join('left join pan_shangpin_attr b on (b.attr_id = a.id and b.good_id ='.$id.')')
                            ->where(array(
                        'a.type_id'=>array('eq',$data['type_id'])
                    ))-> select();
//             
                 
		// 设置页面中的信息
		$this->assign(array(
                    'attrmesDate'=>$attrmesDate,
                    'goodcatData' => $goodcatData,
                          'parentData' => $parentData,
                        'levelData'        =>  $levelData,
                     'phoneData'        =>  $phoneData,
                        'data'        =>  $data,
			'_page_title' => '修改商品',
			'_page_btn_name' => '商品列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }

    public function lst()
    {
    	$model = D('Goods');
    	$data = $model->search(5);
       
        //获取主分类信息
             $parentModel = D('GoodCategory');
		$parentData = $parentModel->getTree();
        // 设置页面中的信息
    	$this->assign(array(
            //设置分页和数据
                'parentData'=>$parentData,
    		'data' => $data['data'],
    		'page' => $data['page'],
            //设置模板数据，建议用_开头，好区分
                  '_page_title' => '商品列表',
	          '_page_btn_name' => '添加商品',
		'_page_btn_link' => U('add'),
    	));
    	$this->display();
    }
    
        public function delete()
	{
		$model = D('goods');
		if(FALSE !== $model->delete(I('get.id')))
			$this->success('删除成功！', U('lst'));
		else 
			$this->error('删除失败！原因：'.$model->getError());
	}
        
        public function ajaxDelPic()
	{
	 $phoneModel=D('good_phone');
         $id=I('get.id');
         
         //删除本地图片
         $picArr=$phoneModel->field('pic,sm_pic,mid_pic,big_pic')
                 ->where(array('id'=>array('eq',$id)))
                 ->find();

          deleteImage($picArr);     
         //删除数据库
           $picArr=$phoneModel->where(array('id'=>array('eq',$id)))
                 ->delete();
	}
        public function getAllType()
               {
        $id=I('get.id');
        $goodAttrModel=D('good_attr');
        $goodAttrData=$goodAttrModel->where(array(
            'type_id'=>array('eq',$id)
        ))->select();
echo json_encode($goodAttrData);
    }
    /*
     * ajax删除属性操作，这里面删除属性操作的时候，也会去删除相应的属性对应的库存
     * 
     */
    public function ajaxDel()
    {
        $id = addslashes(I('get.id'));
        $goodid = addslashes(I('get.good_id'));
        // 删除商品属性之前先删除相应属性的库存量
        $goodnumModel=D('good_number');
        $goodnumModel-> where(
               array(
                   'good_id'=>array('exp', "=$goodid  and find_in_set($id,attr_list)")
               ))->delete();
    
       // 删除商品本身属性
         $shangpinattrModel=D('shangpin_attr');
         $shangpinattrModel->where(array('id' => array('eq',$id)))->delete(); 
        
        
    }
       /*
     * 
     * 
     */
    public function goodnumber()
    {
        $id=I('get.id');
         $goodnumberModel=D('good_number');
         if(IS_POST)
    	{
             
          // 修改之前先清空kucun，在增加
              $goodnumberModel->where(array(
                  'good_id' => array('eq',$id)
              ))->delete();
             
             
         $attrsArr=I('post.attrs');
         $numberArr=I('post.nums');
         // 有可能 2个可选属性对应一个数量，有可能3个属性对应一个数量，所有这里我们就要弄一个比例出来
          $attrCount=count($attrsArr);
          $numberCount=count($numberArr);
         $rate=$attrCount/$numberCount;    // 这个就是一个比例
          $_i=0 ;//开始定义的一个标记 ,这个标记是为了下面的每次循环加上 $rate 个

         
           
           // 下面这方面其实是有bug的，相同的属性会重复增加
           
         foreach($numberArr as $k => $v)
          {
              $_goodId=array();                     //把下面取出来的ID 放这里
            for($i=0;$i<$rate;$i++)
            {
                 
                $_goodId[]=$attrsArr[$_i];
                $_i++;    //这个是比较关键的
            }
             // 获取出来的id是一个数组，然后变成 "，" 隔开的字符串
            
             sort($_goodId,SORT_NUMERIC);// 先排序 ,这个一定要先排序一下，要不然的前面加入购物车，属性顺序以错了就查询不出来库存量。
            $idStr= implode(',', $_goodId);  //这里如果没有属性字段，那么就是空字符串
            if($v>0){
                //数量是大与于0才增加库存
                  $goodnumberModel->add(array(
                 'good_id' => $id,
                 'number'=>$v,
                 'attr_list'=>$idStr
             ));
            };
           
          }

  
         //成功之后跳转到库存。
            $this->success('设置成功！',U('goodnumber?id='.$id));
              exit;
              
    	}
        
        
        //  下面这个是查找所有的属性，按照分组来展示，这个是所有的可选的
        $shangpinattrModel = D('shangpin_attr');
        $shangpinattrData=$shangpinattrModel->alias('a')
                ->field('a.*,b.attr_name')
                ->join('left join pan_good_attr b on b.id=a.attr_id')
                ->where(
                array('good_id'=>array('eq',$id),
                    'b.atrr_type'=>array('neq',1)   //不等于1，就是可选的，1是唯一的属性。
                    ))->select();
        
        $newshangpinattrData=array();
        foreach ($shangpinattrData as $k=>$v){
            $newshangpinattrData[$v['attr_name']][]=$v;
        }
         //  展示的数据结束
   
        
        //  如果刚开始有值那么就查询出来,这个是页面循环使用的。   
      $firstData=  $goodnumberModel->where(array(
            'good_id' => $id
        ))-> select();
             
               // 设置页面中的信息
    	$this->assign(array(
               'firstData' => $firstData,
    		'newshangpinattrData' => $newshangpinattrData,
            //设置模板数据，建议用_开头，好区分
                  '_page_title' => '库存量',
	          '_page_btn_name' => '返回列表',
		'_page_btn_link' => U('lst'),
    	));
    	$this->display();
    }

}