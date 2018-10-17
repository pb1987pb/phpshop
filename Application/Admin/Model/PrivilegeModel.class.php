<?php
namespace Admin\Model;
use Think\Model;
class PrivilegeModel extends Model 
{
	protected $insertFields = array('pri_name','module_name','controller_name','action_name','parent_id');
	protected $updateFields = array('id','pri_name','module_name','controller_name','action_name','parent_id');
	protected $_validate = array(
		array('pri_name', 'require', '权限名称不能为空！', 1, 'regex', 3),
		array('pri_name', '1,30', '权限名称的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('module_name', '1,30', '模块名称的值最长不能超过 30 个字符！', 2, 'length', 3),
		array('controller_name', '1,30', '控制器名称的值最长不能超过 30 个字符！', 2, 'length', 3),
		array('action_name', '1,30', '方法名称的值最长不能超过 30 个字符！', 2, 'length', 3),
		array('parent_id', 'number', '上级权限Id必须是一个整数！', 2, 'regex', 3),
	);
	/************************************* 递归相关方法 *************************************/
	public function getTree()
	{
		$data = $this->select();
		return $this->_reSort($data);
	}
	private function _reSort($data, $parent_id=0, $level=0, $isClear=TRUE)
	{
		static $ret = array();
		if($isClear)
			$ret = array();
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $parent_id)
			{
				$v['level'] = $level;
				$ret[] = $v;
				$this->_reSort($data, $v['id'], $level+1, FALSE);
			}
		}
		return $ret;
	}
	public function getChildren($id)
	{
		$data = $this->select();
		return $this->_children($data, $id);
	}
	private function _children($data, $parent_id=0, $isClear=TRUE)
	{
		static $ret = array();
		if($isClear)
			$ret = array();
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $parent_id)
			{
				$ret[] = $v['id'];
				$this->_children($data, $v['id'], FALSE);
			}
		}
		return $ret;
	}
	/************************************ 其他方法 ********************************************/
	
        public function _before_delete($option)
	{
		// 先找出所有的子分类
		$children = $this->getChildren($option['where']['id']);
		// 如果有子分类都删除掉
		if($children)
		{
			$this->error = '有下级数据无法删除';
			return FALSE;
		}
	}
        
        
           /**
     *  检查当前管理员是否有权限访问这个页面。
     */
    public function checkPri()
    {
        // 获取当前管理员正要访问的模型名称，控制器名称，方法名称
        //  tp 框架中 正好有 这 三个常量
        //   MODULE_NAME CONTROLLER_NAME  ACTION_NAME
       $adminId=session('id');
       // 如果是超级管理员直接返回true

       if($adminId==1)
           return true;
       $adminModel=D('admin_role');
       $has=$adminModel->alias('a')
               ->join('left join pan_role_pri b on b.role_id =a.role_id
                       left join pan_privilege c on b.pri_id = c.id')
               ->where(array(
                   'a.admin_id'=>array('eq',$adminId),
                   'c.module_name'=>array('eq',MODULE_NAME),
                   'c.controller_name'=>array('eq',CONTROLLER_NAME),
                   'c.action_name'=>array('eq',ACTION_NAME)
               ))
               ->count();
        return $has>0;
    }
    
    /*
     * 获取当前登录的管理员所拥有的的两极权限
     */
    
    public function getPris()
    {
         $adminId=session('id');
        $data= S($adminId);
         $pris=array();  //定一个数组来存储这个权限的值
    
          if($adminId==1)
          {
               $priModel=D('privilege');
              $pris=$priModel->select();
          }else
          {
                   $adminModel=D('admin_role');  
                   //  这里 要 distance去重一下 ，因为角色拥有权限会重合大部分。
                    $pris=$adminModel->field('distinct c.*')
                ->alias('a')
               ->join('left join pan_role_pri b on b.role_id =a.role_id
                       left join pan_privilege c on b.pri_id = c.id')
               ->where(array(
                   'a.admin_id'=>array('eq',$adminId)
               ))->select();
              
          }
         
         $resultPris=array();
          //这里面我们只需要获取前两级的，也就是 parent_id为0 的，和它的下一级
          foreach($pris as $k=>$v){
              if($v['parent_id']==0){
                  foreach ($pris as $k1 =>$v1){
                      if($v1['parent_id']==$v['id']){
                          $v['child'][]=$v1;
                      }
                      
                  }
                 $resultPris[]=$v;
                  
              }
          }
         
          // 这个就是一级权限和两级权限
          return  $resultPris;
          
    }

}