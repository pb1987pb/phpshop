<?php
namespace Admin\Model;
use Think\Model;
class MemberLevelModel extends Model 
{
	protected $insertFields = array('level_name','jifen_bottom','jifen_top');
	protected $updateFields = array('id','level_name','jifen_bottom','jifen_top');
	protected $_validate = array(
		array('level_name', 'require', '级别名称不能为空！', 1, 'regex', 3),
		array('level_name', '1,30', '级别名称的值最长不能超过 30 个字符！', 1, 'length', 3),
                array('level_name', '', '级别名称已经存在！', 1, 'unique', 3),
		array('jifen_bottom', 'require', '积分下限不能为空！', 1, 'regex', 3),
		array('jifen_bottom', 'number', '积分下限必须是一个整数！', 1, 'regex', 3),
		array('jifen_top', 'require', '积分上限不能为空！', 1, 'regex', 3),
		array('jifen_top', 'number', '积分上限必须是一个整数！', 1, 'regex', 3),
	);
	public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		$data['data'] = $this->alias('a')->where($where)->group('a.id')->limit($page->firstRow.','.$page->listRows)->select();
		return $data;
	}
	// 添加后
	protected function _after_insert($data, $option)
	{
             $id = $option['where']['id'];
	}
	// 修改前
	protected function _before_update(&$data, $option)
	{
	}
	// 删除前
	protected function _before_delete($option)
	{
		if(is_array($option['where']['id']))
		{
			$this->error = '不支持批量删除';
			return FALSE;
		}
	}
	/************************************ 其他方法 ********************************************/
}