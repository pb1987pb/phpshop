<?php
namespace Home\Controller;
use Think\Controller;
class GoodsController extends NavController {
       // 商品控制器
    
    public function detail(){
        $id=I('get.id');
//        cookie('shopcar',null);
        // 获取商品的基本信息
        $goodsModel=D('Goods');
        $goodData=$goodsModel->find($id);
  
        // 找出前面的所有的分类，制作面包屑
    $cateModel=D('GoodCategory');
   $cateData=   $cateModel->getPrevCat($goodData['category_id']);

        //  获取商品的相册信息
    $picModel=D('good_phone');
   $picArr= $picModel->where(array(
        'good_id' => array('eq',$id)
    ))-> select();
   
   // 获取商品本身所有参数的数据
    $spattrModel=D('shangpin_attr');
    $spattrData=$spattrModel->alias('a')
            ->field('a.*,b.attr_name,b.atrr_type')->join('left join pan_good_attr b on b.id = a.attr_id')->where(array(
        'a.good_id' => array('eq',$id)
    ))->select();

    
    $kexuanData=array(); //可选参数数组
    $weiyiData=array();//唯一参数数组
    
    foreach($spattrData as $k => $v)
    {
        if($v['atrr_type']==2){
            $kexuanData[$v['attr_name']][]=$v;
        }elseif ($v['atrr_type']==1) {
                $weiyiData[]=$v;
            }
    }

    

    // 获取会员价格
    
    $memberModel=D('member_price');
    $memberData=$memberModel->alias('a')->field('a.*,b.level_name')
            ->join('left join pan_member_level b on b.id = a.level_id')
    ->where(array(
        'good_id' => array('eq',$id)
    )) ->select();
//   dump($memberData);


     $viewPath=C('IMAGE_CONFIG');   // 获取配置中的路径地址
//      dump($viewPath['viewPath']);
   
$this->assign(array(
                         'goodData'=>$goodData,
                         'cateData' =>  $cateData,
                          'picArr' => $picArr,
                          'spattrData' => $spattrData,
                          'kexuanData' => $kexuanData,
                          'weiyiData' => $weiyiData,
                       'memberData'=>$memberData,
                          'viewPath'=>$viewPath['viewPath'],
                          '_show_nav'=> 0,
			'_page_title' => '商品详情页',
		        '_page_keywords' => '商品详情页',
			'_page_description' => '商品详情页',
		));
       $this->display();
    }
    
      //     获取浏览商品历史的id数组
    public function displayHistory(){
          $id=I('get.id');
          $goodsModel=D('Goods');
       $idArr= $goodsModel->displayHistory($id);
         // 因为上面是一个二维数组，所以前端得到的是一个js数组
       echo json_encode($idArr);
    }
    
    
    public function ajaxGetPrice()
    {
           $id=I('get.id');
          $goodsModel=D('Goods');
          echo $goodsModel->getPrice($id);
    }
}