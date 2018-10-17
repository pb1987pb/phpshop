<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends NavController {
     //  首页控制器
    
    public function index(){
        
        //   测试静态页面失效的时候，雪崩的问题
//        $file=  uniqid();  //微秒生成一个唯一的id
//       file_put_contents('./piao/'.$file,'abc');  //创建文件夹，写数据进去。
        
        
         //自动登录的代码，判断是否有cookie，然后验证。
        $memberModel=D('member');
        $memberModel->autoLogin();

                
     $goodsModel=D('Goods');
      $goodsData=$goodsModel->getPro();// 获取推荐商品
      // 获取新品，热卖，精品
       $newData=$goodsModel->getRec('is_new');
        $hotData=$goodsModel->getRec('is_hot');
         $bestData=$goodsModel->getRec('is_best');
         //楼层数据
        $cateGory=D('GoodCategory');
        $floorData= $cateGory->getIndex();
   
$this->assign(array(
                        'goodsData' => $goodsData,
                        'newData' => $newData,
                        'hotData' => $hotData,
                        'bestData' => $bestData,
                        'floorData'=>$floorData,
                          '_show_nav'=> 1,
			'_page_title' => '首页',
			'_page_keywords' => '首页',
			'_page_description' => '首页',
		));
       $this->display();
    }
}