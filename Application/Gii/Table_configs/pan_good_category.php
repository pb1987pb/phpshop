<?php
return array(
	'tableName' => 'pan_good_category',    // 表名
	'tableCnName' => '商品分类表',  // 表的中文名
	'moduleName' => 'Admin',  // 代码生成到的模块
	'withPrivilege' => FALSE,  // 是否生成相应权限的数据
	'topPriName' => '',        // 顶级权限的名称
	'digui' => 1,             // 是否无限级（递归）
	'diguiName' => 'catename',        // 递归时用来显示的字段的名字，如cat_name（分类名称）
	'pk' => 'id',    // 表中主键字段名称
	/********************* 要生成的模型文件中的代码 ******************************/
	// 添加时允许接收的表单中的字段
	'insertFields' => "array('catename','parent_id')",
	// 修改时允许接收的表单中的字段
	'updateFields' => "array('id','catename','parent_id')",
	'validate' => "
		array('catename', 'require', '分类名称不能为空！', 1, 'regex', 3),
		array('catename', '1,30', '分类名称的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('parent_id', 'number', '父类id必须是一个整数！', 2, 'regex', 3),
	",
	/********************** 表中每个字段信息的配置 ****************************/
	'fields' => array(
		'catename' => array(
			'text' => '分类名称',
			'type' => 'text',
			'default' => '',
		),
		'parent_id' => array(
			'text' => '父类id',
			'type' => 'text',
			'default' => '0',
		),
	),
	/**************** 搜索字段的配置 **********************/
	'search' => array(
		
	),
);