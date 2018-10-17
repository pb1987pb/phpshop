<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends BaseController
{
    public function index(){
        
     $this->display();
    }
     public function top(){
      $this->display();
    }
     public function main(){
     $this->display();
    }
     public function menu(){
         
         // 设置页面中的信息
         $priModel=D('privilege');
         $priData=$priModel->getPris();
		$this->assign(array(
			'priData' => $priData,

		));
        $this->display();
    }
}