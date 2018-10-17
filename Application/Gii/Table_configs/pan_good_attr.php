<?php
return array(
	'tableName' => 'pan_good_attr',    // 表名
	'tableCnName' => '商品属性表',  // 表的中文名
	'moduleName' => 'Admin',  // 代码生成到的模块
	'withPrivilege' => FALSE,  // 是否生成相应权限的数据
	'topPriName' => '',        // 顶级权限的名称
	'digui' => 0,             // 是否无限级（递归）
	'diguiName' => '',        // 递归时用来显示的字段的名字，如cat_name（分类名称）
	'pk' => 'id',    // 表中主键字段名称
	/********************* 要生成的模型文件中的代码 ******************************/
	// 添加时允许接收的表单中的字段
	'insertFields' => "array('type_id','attr_name','atrr_type','attr_input_type','attr_value')",
	// 修改时允许接收的表单中的字段
	'updateFields' => "array('id','type_id','attr_name','atrr_type','attr_input_type','attr_value')",
	'validate' => "
		array('type_id', 'require', '类型id不能为空！', 1, 'regex', 3),
		array('type_id', 'number', '类型id必须是一个整数！', 1, 'regex', 3),
		array('attr_name', 'require', '属性名称不能为空！', 1, 'regex', 3),
		array('attr_name', '1,150', '属性名称的值最长不能超过 150 个字符！', 1, 'length', 3),
		array('atrr_type', 'require', '属性本身的类型，通常有唯一、单选和多选之分不能为空！', 1, 'regex', 3),
		array('atrr_type', 'number', '属性本身的类型，通常有唯一、单选和多选之分必须是一个整数！', 1, 'regex', 3),
		array('attr_input_type', 'require', '属性的输入类型，通常有文本框、下拉列表、文本域之分不能为空！', 1, 'regex', 3),
		array('attr_input_type', 'number', '属性的输入类型，通常有文本框、下拉列表、文本域之分必须是一个整数！', 1, 'regex', 3),
	",
	/********************** 表中每个字段信息的配置 ****************************/
	'fields' => array(
		'type_id' => array(
			'text' => '类型id',
			'type' => 'text',
			'default' => '',
		),
		'attr_name' => array(
			'text' => '属性名称',
			'type' => 'text',
			'default' => '',
		),
		'atrr_type' => array(
			'text' => '属性本身的类型，通常有唯一、单选和多选之分',
			'type' => 'text',
			'default' => '',
		),
		'attr_input_type' => array(
			'text' => '属性的输入类型，通常有文本框、下拉列表、文本域之分',
			'type' => 'text',
			'default' => '',
		),
		'attr_value' => array(
			'text' => '属性的可选值',
			'type' => 'html',
			'default' => '',
		),
	),
	/**************** 搜索字段的配置 **********************/
	'search' => array(
		array('type_id', 'normal', '', 'eq', '类型id'),
		array('attr_name', 'normal', '', 'like', '属性名称'),
		array('atrr_type', 'normal', '', 'eq', '属性本身的类型，通常有唯一、单选和多选之分'),
		array('attr_input_type', 'normal', '', 'eq', '属性的输入类型，通常有文本框、下拉列表、文本域之分'),
		array('attr_value', 'normal', '', 'eq', '属性的可选值'),
	),
);