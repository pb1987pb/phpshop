<?php
namespace Admin\Controller;
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
             $this->redirect('login/login');
         }
         // 所有的管理员都可以进入后台的首页
         //  MODULE_NAME 和  CONTROLLER_NAME 第一个用于是大写，及时进来的是小写的也会变成大写
         // ACTION_NAME 是进来的是大写就是大写，小写就是小写
         if(CONTROLLER_NAME == 'Index')
          return true;
         
         //检测是否有权限
          $priModel = D('Privilege');
          if(!$priModel->checkPri()){
               $this->error('无权限访问这个页面');
          }
    }

}