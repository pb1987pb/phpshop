<?php
namespace Home\Controller;
use Think\Controller;
class NavController extends Controller {

    public function __construct()
    {
         parent::__construct();
            	// 设置页面中的信息
        // 页面获取导航，那么这里肯定是在导航模型里面去设置
        $cateGory=D('GoodCategory');
        $cateData=$cateGory->getAllThreeCat();
        
         // 图片展示地址
           $ic = C('IMAGE_CONFIG'); 
           $picView = $ic['viewPath'];
        
        $this->assign(array(
                            'cateData' => $cateData,
                             'picView' => $picView
            ));
    }
    
}

