<?php
namespace Admin\Model;
use Think\Model;
class BrandModel extends Model 
{
        //添加的时候可以接收的字段
	protected $insertFields = array('brand_name','site_url','logo');
	// 修改的时候可以接受的字段
        protected $updateFields = array('id','brand_name','site_url','logo');
           //create方法是对表单提交的POST数据进行自动验	
         //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
         //验证规则包括：require 字段必须、email 邮箱、url URL地址、currency 货币、number 数字。
         // 验证条件在实际就是 1（必须）或者 2（不为空），默认是 0基本不用，0表示表单有这个字段就验证。
        //验证时间 1 新增数据时  2，编辑数据时   3，全部情况下。
	protected $_validate = array(
		array('brand_name', 'require', '品牌名称不能为空！', 1),
               
	);
	
	public function search($pageSize = 5)
	{
		/*************** 搜索开始 ******************/
		$where = array();  // 空的where条件
		// 商品名称
		$gn = I('get.gn');
		if($gn)
			$where['brand_name'] = array('like', "%$gn%");  // WHERE goods_name LIKE '%$gn%'
		
		/*************** 搜索结束 ******************/
                
           /***************** 排序 *****************/
		$orderby = 'id';      // 默认的排序字段 
		$orderway = 'desc';   // 默认的排序方式

            
		/*************** 翻页 ****************/
		// 取出总的记录数
		$count = $this->where($where)->count();
		// 生成翻页类的对象
		$pageObj = new \Think\Page($count, $perPage);
		// 设置样式
		$pageObj->setConfig('next', '下一页');
		$pageObj->setConfig('prev', '上一页');
		// 生成页面下面显示的上一页、下一页的字符串
		$pageString = $pageObj->show();
                
                
                
		/************** 取某一页的数据 ***************/
		/**
		 * SELECT a.*,b.brand_name FROM p39_goods a LEFT JOIN p39_brand b ON a.brand_id=b.id
		 */
		$data = $this->order("$orderby $orderway")                    // 排序
		->where($where)                                               // 搜索
		->limit($pageObj->firstRow.','.$pageObj->listRows)            // 翻页
		->select();
		/************** 返回数据和分页 ******************/
		return array(
			'data' => $data,  // 数据
			'page' => $pageString,  // 翻页字符串
		);
	}
	// 添加前
	protected function _before_insert(&$data, $option)
	{          
		if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0)
		{
			$ret = uploadOne($_FILES['logo'], 'logos');
			if($ret['ok'] == 1)
			{
				$data['logo'] = $ret['images'][0];
			}
			else 
			{
				$this->error = $ret['error'];
				return FALSE;
			}
		}
                
	}
	// 修改前
        
	protected function _before_update(&$data, $option)
	{
		if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0)
		{
			$ret = uploadOne($_FILES['logo'], 'logos', array());
			if($ret['ok'] == 1)
			{
				$data['logo'] = $ret['images'][0];
			}
			else 
			{
				$this->error = $ret['error'];
				return FALSE;
			}
			deleteImage(array(
				I('post.old_logo'),
			));
		}
               
	}
        
        //添加后
        protected function _after_insert($data, $option)
	{
   
	
	}
	// 删除前
	protected function _before_delete($option)
	{
		$id = $option['where']['id'];   // 要删除的商品的ID
	}
	/************************************ 其他方法 ********************************************/
}