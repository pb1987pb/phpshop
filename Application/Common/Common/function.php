<?php
/**
 * 使用一个表中的数据制作下拉框
 *
 */
function buildSelect($tableName, $selectName, $valueFieldName, $textFieldName, $selectedValue = '')
{
     

	$model = D($tableName);
	$data = $model->field("$valueFieldName,$textFieldName")->order('id asc')->select();
	$select = "<select name='$selectName'><option value=''>请选择</option>";
	foreach ($data as $k => $v)
	{
		$value = $v[$valueFieldName];
		$text = $v[$textFieldName];
		if($selectedValue && $selectedValue==$value)
			$selected = 'selected="selected"';
		else 
			$selected = '';
		$select .= '<option '.$selected.' value="'.$value.'">'.$text.'</option>';
	}
	$select .= '</select>';
	echo $select;
}
/*
 *  批量删除图片
 *  @param array $image  图片的路径
 */
function deleteImage($image = array())
{
	$savePath = C('IMAGE_CONFIG');
	foreach ($image as $v)
	{
		unlink($savePath['rootPath'] . $v);
	}
}
/*
 *  上传单张图片和生成缩略图
 *  @param array $imgArr  单行图片信息，类似 $_FILES[$imgName]
 *  @param array $dirName  文件夹文字，比如商品图片，'goods'
 *  @param array $thumb 缩略图的尺寸，类似下面这种
 *                    array(
				array(500, 500),
				array(300, 300),
			))
 * @return array  缩略图和原图的路径
 */
        function uploadOne($imgArr, $dirName, $thumb = array())
{
		$ic = C('IMAGE_CONFIG');
		$upload = new \Think\Upload(array(
			'rootPath' => $ic['rootPath'],
			'maxSize' => $ic['maxSize'],
			'exts' => $ic['exts'],
		));// 实例化上传类
		$upload->savePath = $dirName . '/'; // 图片二级目录的名称
		// 上传文件 
                $info   =   $upload->uploadOne($imgArr);
		if(!$info)
		{
			return array(
				'ok' => 0,
				'error' => $upload->getError(),
			);
		}
		else
		{
			$ret['ok'] = 1;
                     $ret['images'][0] = $logoName = $info['savepath'] . $info['savename'];
		    // 判断是否生成缩略图
		    if($thumb)
		    {
		    	$image = new \Think\Image();
		    	// 循环生成缩略图
		    	foreach ($thumb as $k => $v)
		    	{
		    		$ret['images'][$k+1] = $info['savepath'] . 'thumb_'.$k.'_' .$info['savename'];
		    		// 打开要处理的图片
				    $image->open($ic['rootPath'].$logoName);
				    $image->thumb($v[0], $v[1])->save($ic['rootPath'].$ret['images'][$k+1]);
		    	}
		    }
		    return $ret;
		}
}
/*
 *  前端页面实现图片
 *  @param array $url  图片的路径
 *  @param array $url  图片的宽度
 *  @param array $url  图片的高度
 */
function showImage($url, $width = '', $height = '')
{
	$ic = C('IMAGE_CONFIG');
	if($width)
		$width = "width='$width'";
	if($height)
		$height = "height='$height'";
	echo "<img $width $height src='{$ic['viewPath']}$url' />";
}
// 有选择性的过滤XSS --》 说明：性能非常低-》尽量少用
function removeXSS($data)
{
	require_once './HtmlPurifier/HTMLPurifier.auto.php';
	$_clean_xss_config = HTMLPurifier_Config::createDefault();
	$_clean_xss_config->set('Core.Encoding', 'UTF-8');
	// 设置保留的标签
	$_clean_xss_config->set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]');
	$_clean_xss_config->set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
	$_clean_xss_config->set('HTML.TargetBlank', TRUE);
	$_clean_xss_obj = new HTMLPurifier($_clean_xss_config);
	// 执行过滤
	return $_clean_xss_obj->purify($data);
}
//递归获取树形结构
function _getTree($data, $parent_id=0, $level=0)
	{
		static $_ret = array();
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $parent_id)
			{
				$v['level'] = $level;  // 用来标记这个分类是第几级的
				$_ret[] = $v;
				// 找子分类
				$this->_getTree($data, $v['id'], $level+1);
			}
		}
		return $_ret;
	}
        // 获取所有子分类的id集合，不包含自己的id
        function _getChildren($data, $catId, $isClear = FALSE)
	{
		static $_ret = array();  // 保存找到的子分类的ID
		if($isClear)
			$_ret = array();
		// 循环所有的分类找子分类
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $catId)
			{
				$_ret[] = $v['id'];
				// 再找这个$v的子分类
				$this->_getChildren($data, $v['id']);
			}
		}
		return $_ret;
	}
        
        
       function array_null($arr){
    if(is_array($arr)){
     foreach($arr as $k=>$v){
      if($v&&!is_array($v)){
        return false;
      }
       $t=array_null($v);
       if(!$t){
         return false;
       }
     }
     return true;
     }else{
       if(!$arr){
         return true;
       }
       return false;
     }
  }
  
        
      