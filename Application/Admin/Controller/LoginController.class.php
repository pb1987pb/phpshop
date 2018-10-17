<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller 
{
     /**
      * 登录
      */
    public function login()
    {
         $model = D('Admin');
         if(IS_POST)
    	{
    		
    		if($model->validate($model->_login_validate)-> create())
    		{
             
    			if($model->checkLogin())
    			{
    				$this->success('登录成功！', U('Index/index'));
    				exit;
    			}
    		}
                $this->error($model->getError());
              
    	}

          if($result=$model->autoLogin()){
               $this->redirect('Index/index');
              exit;
          }
          $this->display();
    }
    /**
     *   退出登录
     */
      public function loginOut()
    {
       $model = D('Admin');
       $model->loginOut();
        $this->redirect('login/login');
        
    }
    
     public function chkcode()
    {
       
             $cfg = array(
//            'imageH'    =>  45,               // 验证码图片高度
//            'imageW'    =>  100,               // 验证码图片宽度
            'length'    =>  4,               // 验证码位数
            'fontSize'  =>  15,              // 验证码字体大小(px)
            'fontttf'   =>  '4.ttf',              // 验证码字体，不设置随机获取
//                 'useNoise'    =>    false
        );
        //实例化verify类对象，对象调用成员方法即可
        //$very = new Verify($cfg);
        $very = new \Think\Verify($cfg);  //完全限定名称方式 元素访问
        $very -> entry();
    }
    

}