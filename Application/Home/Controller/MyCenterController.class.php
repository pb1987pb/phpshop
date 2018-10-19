<?php
namespace Home\Controller;
use Think\Controller;
class MyCenterController extends Controller {

     //
    public function __construct()
    {
         parent::__construct();
      
        
        $this->assign(array(
                            'cateData' => $cateData,
                             'picView' => $picView
            ));
    }
    
}

