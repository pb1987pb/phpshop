<?php
namespace Admin\Model;
use Think\Model;
class GoodAttrModel extends Model 
{
	protected $insertFields = array('type_id','attr_name','atrr_type','attr_input_type','attr_value');
	protected $updateFields = array('id','type_id','attr_name','atrr_type','attr_input_type','attr_value');
	protected $_validate = array(
		array('type_id', 'require', '类型id不能为空！', 1, 'regex', 3),
		array('type_id', 'number', '类型id必须是一个整数！', 1, 'regex', 3),
		array('attr_name', 'require', '属性名称不能为空！', 1, 'regex', 3),
		array('attr_name', '1,150', '属性名称的值最长不能超过 150 个字符！', 1, 'length', 3),
		array('atrr_type', 'require', '属性本身的类型，通常有唯一、单选和多选之分不能为空！', 1, 'regex', 3),
		array('atrr_type', 'number', '属性本身的类型，通常有唯一、单选和多选之分必须是一个整数！', 1, 'regex', 3),
		array('attr_input_type', 'require', '属性的输入类型，通常有文本框、下拉列表、文本域之分不能为空！', 1, 'regex', 3),
		array('attr_input_type', 'number', '属性的输入类型，通常有文本框、下拉列表、文本域之分必须是一个整数！', 1, 'regex', 3),
	);
	public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		if($type_id = I('get.type_id'))
			$where['type_id'] = array('eq', $type_id);
		if($attr_name = I('get.attr_name'))
			$where['attr_name'] = array('like', "%$attr_name%");
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
             $id = $data['id'];
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