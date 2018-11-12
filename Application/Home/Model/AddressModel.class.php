<?php
namespace Home\Model;
use Think\Model;
class AddressModel extends Model 
{ 
    
	protected $insertFields = array('shr_name','shr_tel','shr_province','shr_city','shr_area','shr_address','poscode','is_default');
        
        
        protected $updateFields = array('id','shr_name','shr_tel','shr_province','shr_city','shr_area','shr_address','poscode','is_default');
        
        
        protected $_validate = array(
                array('shr_name', 'require', '收货人姓名不能为空！', 1, 'regex', 3),
                 array('shr_tel', 'require', '收货人手机号码不能为空！', 1, 'regex', 3),
              array('shr_tel', 'check_phone', '手机号码错误！', 1, 'callback', 3),
                 array('shr_province', 'require', '收货人省份不能为空！', 1, 'regex', 3),
             array('shr_city', 'require', '收货人城市不能为空！', 1, 'regex', 3),
             array('shr_area', 'require', '收货人地区不能为空！', 1, 'regex', 3),
            array('shr_address', 'require', '收货人详情地址不能为空！', 1, 'regex', 3),
	);
        
         // 验证手机号码是否正确
        function check_phone($phone){
if(preg_match("/^1[345678]{1}\d{9}$/",$phone))
    return true;
else
    return FALSE;

        }
        // 添加地址前
	protected function _before_insert(&$data, &$option)
	{      
         
                    
           
            
            $member_id=session('m_id');
         $res = $this->where(array(
          'member_id'=>array('eq',$member_id)))->select();
      if(count($res)>=10){
    			$this->error="收货地址最多只能添加10条,您的收货地址已经达到限度！";
                       return FALSE;
    		}
                elseif(count($res)==0){
                    //  添加第一个时候就设置为默认地址
                $data['is_default'] = '是';
    		} 
                else {
                    // 如果勾选了默认地址的
                         if($data['is_default']=="是"){
	            	// 查询开始的是默认地址的 ，把这个地址传递到修改之后的钩子里面
	            	$option["oldid"] = $this->where(
                                array('member_id'=>array('eq',$member_id),
                            'is_default'=>array('eq',"是")))->getField("id");
	            }   	
               
                    
                    }
        
                    
                 // 设置其他字段
              $data['addtime']=time();
	     $data['member_id']=$member_id;
             
             // 开启事物。
             $this->startTrans();  
        
	}
        
        // 添加地址后
	protected function _after_insert($data, $option)
	{
             //判断这里面是否有这个字段，有这个字段，证明就是添加设置的是默认的地址
            // 那么这里就是要把开始的默认地址设置为不是默认地址
            if($olodid=$option["oldid"])
            {
               $ret =  $this-> where(array( 'id' => array('eq',$olodid),
                         ))->setField('is_default','否');  
                 
                  if(!$ret)
                {
                    $this->rollback();
                    $this->error="修改默认地址失败";
                    return FALSE;
                }
            }
             
            //提交事物
             $this->commit(); 
	}
        
        
        
         //修改地址之前
	protected function _before_update(&$data, &$option)
        {
              
          //修改地址看是否传递的是勾选的默认地址
            if($data['is_default']=='是'){
                // 查询开始的默认地址的id
                 $member_id=session('m_id');
                     // 查找开始是否有默认的地址
             $defid=$this-> where(array( 'member_id' => array('eq',$member_id),
                           'is_default' => array('eq','是')
                         ))->getField('id');
             
                  // 有默认地址，并且这个地址不是自己，那么就要开启事物了
               if($defid && $defid!=$option['where']['id'])
                   {
                   $option['oldadd']=$defid;
               
                    // 开启事物。
            $this->startTrans(); 
               }
            }else
            {
                $data['is_default']='否';
            }
        }
        
        // 修改地址之后
        protected function _after_update($data, $option)
        {
          if($deaid=$option['oldadd']){
                $ret =  $this-> where(array( 'id' => array('eq',$deaid),
                         ))->setField('is_default','否');  
                 
                  if(!$ret)
                {
                 $this->rollback();
                    $this->error="修改默认地址失败";
                    return FALSE;
                }
                   $this->commit(); 
            }
            
        }
  
        // 设置默认地址
        public function setDefault($id)
        {
            if(!$id)
            {
                   $this->error="异常操作";
                  return FALSE;
            }
             $member_id=session('m_id');
           //首选看这个地址是是否存在 
            $old=$this->where(array(
                'member_id' => array('eq',$member_id),
                'id' => array('eq',$id)
            ))->find();
             if(!$old)
            {
                   $this->error="地址不存在";
                  return FALSE;
            }
           
            // 查找开始是否有默认的地址
             $defid=$this-> where(array( 'member_id' => array('eq',$member_id),
                           'is_default' => array('eq','是')
                         ))->getField('id');
             if($defid){
                 // 开始有默认地址，就要修改两个，就开启事物
                 // 开启事物。
             $this->startTrans();
   
            $ret = $this-> where(array( 'id' => array('eq',$defid)
                         ))->setField('is_default','否');  
             
              if($ret==FALSE)
                {
                    $this->rollback();
                    $this->error="修改默认地址失败";
                    return FALSE;
                }
             
               // 把自己设置为是
           $nret =  $this-> where(
                     array('id'=>array('eq',$id))
                     )->setField('is_default','是');  
           
                if(!$nret)
                {
                    $this->rollback();
                    $this->error="设置默认地址失败";
                    return FALSE;
                }
                
                $this->commit(); 
             }  
             else {
                      // 把自己设置为是
           $nret =  $this-> where(
                     array('id'=>array('eq',$id))
                     )->setField('is_default','是');  
            if(!$nret)
                {
                    $this->error="设置默认地址失败";
                    return FALSE;
                }
             }
              
             return TRUE;
            
        }
        
        //删除地址前
         protected function _before_delete($option) 
         {
             $id = $option['where']['id'];
             if(!$res = $this->find($id))
             {
                  $this->error="地址不存在";
                  return FALSE;
             }
         }
}