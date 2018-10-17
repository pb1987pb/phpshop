<?php
namespace Home\Controller;
use Think\Controller;
class MemberController extends Controller 
{
       // 会员控制器，控制登录，注册的 
    
    
       // ajax 验证是否登录
	public function ajaxChkLogin()
	{
		if(session('m_id'))
			echo json_encode(array(
				'code' => 1,
				'username' => session('m_username'),
			));
		else 
			echo json_encode(array(
				'code' => 0
                               
			));
	}

        
	// 制作验证码
	public function chkcode()
	{
		     $cfg = array(
//            'imageH'    =>  45,               // 验证码图片高度
//            'imageW'    =>  100,               // 验证码图片宽度
            'length'    =>  4,               // 验证码位数
            'fontSize'  =>  15,              // 验证码字体大小(px)
            'fontttf'   =>  '4.ttf',              // 验证码字体，不设置随机获取
              'useNoise'    =>    false
        );
        //实例化verify类对象，对象调用成员方法即可
        //$very = new Verify($cfg);
        $very = new \Think\Verify($cfg);  //完全限定名称方式 元素访问
        $very -> entry();
	}
        
        public function ajaxLogin()
        {
            $model = D('Member');
    		if($model->validate($model->_login_validate)->create())
    		{
    			if($model->checkLogin(I('post.member')))
    			{
                             // 下面这个是后台用session 跳转的方法
//                            $returnUrl=U('/');
//                           $back= session('returnUrl');  //  从session里面获取跳转回来的链接                     
//                            if($back)
//                            {
//                               session('returnUrl',null);  //清空跳转回来的链接
//                               $returnUrl=$back;  
//                            }
//                            

                              echo json_encode(array(
				'code' => 1
			));
    				exit;
    			}
    		 }
   
                
                        echo json_encode(array(
				'code' => 0,
				'mes' =>$model->getError()
			));
            
         }
        
        
    public function login()
    {
//    	if(IS_POST)
//    	{
//    		$model = D('Member');
//    		if($model->validate($model->_login_validate)->create())
//    		{
//    			if($model->checkLogin(I('post.member')))
//    			{
//                            $returnUrl=U('/');
//                           $back= session('returnUrl');  //  从session里面获取跳转回来的链接                     
//                            if($back)
//                            {
//                               session('returnUrl',null);  //清空跳转回来的链接
//                               $returnUrl=$back;  
//                            }
//                            
//    			$this->success('登录成功！', $returnUrl);
//
//    				exit;
//    			}
//    		}
//    		$this->error($model->getError());     
//                
//    	}
    	// 设置页面信息
        
      
        
        
    	$this->assign(array(
    		'_page_title' => '登录',
    		'_page_keywords' => '登录',
    		'_page_description' => '登录',
    	));
    	$this->display();
    }
    
    public function regist()
    {
    	if(IS_POST)
    	{
    		$model = D('member');
    		if($model->create(I('post.'), 1))
    		{
                      
    			if($model->add())
    			{
                            
                                  //1，注册成功之后，这里是跳转到登录页面。
    				$this->success('注册成功！', U('login'));
//                                // 2,注册成功，如果我们不需要登录，直接到首页，那我们该怎么做,在增加成功之后的钩子函数里面
//                        $this->success('注册成功！', U('Index/index'));
    			}
    		}
    		$this->error($model->getError());
    	}
    	// 设置页面信息
    	$this->assign(array(
    		'_page_title' => '注册',
    		'_page_keywords' => '注册',
    		'_page_description' => '注册',
    	));
    	$this->display();
    }
    
	public function logout()
    {
    	$model = D('Member');
    	$model->logout();
    	redirect('/');
    }
  
}





