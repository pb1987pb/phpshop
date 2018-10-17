<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller 
{
    public function __construct()
    {
        // 用  __construct 必须先调用父类的构造函数 ，如果用 _initialize() 就不需要
        parent::__construct();
    
         if(!session('id')){
//             $this->error('请先登录',U('login/login'));
             //或者直接跳转也可以 。
             $this->redirect('member/login');
         }
        
    }

}