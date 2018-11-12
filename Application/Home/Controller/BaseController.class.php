<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller 
{
    public $m_id; //把sessionid放在属性里面
    public function __construct()
    {
        // 用  __construct 必须先调用父类的构造函数 ，如果用 _initialize() 就不需要
        parent::__construct();
//         var callback=Util::get_domain().$_SERVER['REQUEST_URT'];
//          dump(callback);
         if(!session('m_id')){
//             $this->error('请先登录',U('login/login'));
             //或者直接跳转也可以 。
//             var callback=Util::get_domain().$_SERVER['REQUEST_URT'];
//             dump(callback);
             $this->redirect('member/login');
         }
        $this->m_id=session('m_id');
         
    }

}