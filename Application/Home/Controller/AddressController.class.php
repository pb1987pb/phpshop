<?php
namespace Home\Controller;
use Think\Controller;
class AddressController extends Controller {
       // 地址控制器
    
     public function ajaxAlladd()
     {
         $addressModel = D('address');
         $addData=$addressModel->select();
         echo json_encode($addData);

     }
      //ajax 添加新地址
    public function ajaxAdd()
    {

    		$addressModel = D('address');
    		if($addressModel->create(I('post.'), 1))
    		{
                    
    			if($id = $addressModel->add())
    			{
    			echo json_encode(array(
				'code' => 1,
                                'id' => $id
			));
    				exit;
    			}
    		}
                
                echo json_encode(array(
				'code' => 0,
				'mes' => $addressModel->getError()
			));
                
    }

   
    
        //ajax 修改新地址
    public function ajaxEdit()
    {
    		$addressModel = D('address');
    		if($addressModel->create(I('post.'), 2))
    		{
                    
    			if($addressModel->save() !== FALSE)
    			{
    			echo json_encode(array(
				'code' => 1,
                                'id' => I('post.id')
			));
    				exit;
    			}  
                         
                          
    		}
            
                    echo json_encode(array(
				'code' => 0,
				'mes' => $addressModel->getError()
			));
             
                
                
    }
    
    // ajax 删除地址
     public function ajaxDel()
     {
         
         	$model = D('address');
		if(FALSE !== $model->delete(I('get.id')))
                {
                    echo json_encode(array(
				'code' => 1
			));
                }
                 
		else 
                {
                                echo json_encode(array(
				'code' => 0,
                               'mes' => $model->getError()
			));
                }
     
        
         
     }
    
     //ajax 设置默认地址
    public function ajaxDefault()
    {
        $addressModel=D('address');
        $id=I('get.id');
        if($res=$addressModel->setDefault($id))
        {
             echo json_encode(array(
				'code' => 1
			));
        
        } 
        else {
               echo json_encode(array(
				'code' => 0,
				'mes' =>$addressModel->getError()
			));
        }
    }
            
}