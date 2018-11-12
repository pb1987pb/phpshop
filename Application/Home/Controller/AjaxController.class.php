<?php
namespace Home\Controller;
use Think\Controller;
//需要登录的时候，用这个控制器
class AjaxController extends Controller 
{
   
    public $m_id; //把sessionid放在属性里面
    public function __construct()
    {
        // 用  __construct 必须先调用父类的构造函数 ，如果用 _initialize() 就不需要
        parent::__construct();

         if(!session('m_id')){
        echo json_encode(array(
				'code' => -1,
				'mes' =>'登录已过期'
			));
              exit;
         }
        $this->m_id=session('m_id');
    }
}