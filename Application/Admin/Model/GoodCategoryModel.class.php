<?php
namespace Admin\Model;
use Think\Model;
class GoodCategoryModel extends Model 
{
	protected $insertFields = array('catename','parent_id','is_floor');
	protected $updateFields = array('id','catename','parent_id','is_floor');
	protected $_validate = array(
		array('catename', 'require', '分类名称不能为空！', 1, 'regex', 3),
		array('catename', '1,30', '分类名称的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('parent_id', 'number', '父类id必须是一个整数！', 2, 'regex', 3),
	);
	/************************************* 递归相关方法 *************************************/
	public function getTree()
	{
		$data = $this->select();
		return $this->_reSort($data);
	}
        //
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
	public function _before_delete(&$option)
	{
		// 先找出所有的子分类
		$children = $this->getChildren($option['where']['id']);
                $children[]=$option['where']['id'];//把自己也组合到这个数组中。
                $option['where']['id']= array('in',$children);
                //
		// 如果有子分类都删除掉
//		if($children)
//		{
//			$this->error = '有下级数据无法删除';
//			return FALSE;
//		}
	}
        
        
   
       
}