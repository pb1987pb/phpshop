<?php
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model 
{
        //添加的时候可以接收的字段
	protected $insertFields = array('goods_name','market_price','shop_price');
	// 修改的时候可以接受的字段
        protected $updateFields = array('id','goods_name','market_price','shop_price');
           //create方法是对表单提交的POST数据进行自动验	
         //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
         //验证规则包括：require 字段必须、email 邮箱、url URL地址、currency 货币、number 数字。
         // 验证条件在实际就是 1（必须）或者 2（不为空），默认是 0基本不用，0表示表单有这个字段就验证。
        //验证时间 1 新增数据时  2，编辑数据时   3，全部情况下。
	protected $_validate = array(
		array('goods_name', 'require', '商品名称不能为空！', 1),
		array('market_price', 'currency', '市场价格必须是货币类型！', 1), 
                array('name','','帐号名称已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一  
                array('value',array(1,2,3),'值的范围不正确！',2,'in'), // 当值不为空的时候判断是否在一个范围内 
                array('repassword','password','确认密码不正确',0,'confirm'), // 验证确认密码是否和密码一致  
                array('password','checkPwd','密码格式不正确',0,'function'), // 自定义函数验证密码格式
	);
	
	public function search($pageSize = 5)
	{
		/*************** 搜索开始 ******************/
		$where = array();  // 空的where条件
		// 商品名称
		$gn = I('get.gn');
		if($gn)
			$where['a.goods_name'] = array('like', "%$gn%");  // WHERE goods_name LIKE '%$gn%'
		// 价格
		$fp = I('get.fp');
		$tp = I('get.tp');
		if($fp && $tp)
			$where['a.shop_price'] = array('between', array($fp, $tp)); // WHERE shop_price BETWEEN $fp AND $tp
		elseif ($fp)
			$where['a.shop_price'] = array('egt', $fp);   // WHERE shop_price >= $fp
		elseif ($tp)
			$where['a.shop_price'] = array('elt', $tp);   // WHERE shop_price <= $fp
		// 是否上架
		$ios = I('get.ios');
		if($ios)
			$where['a.is_on_sale'] = array('eq', $ios);  // WHERE is_on_sale = $ios
		// 添加时间
		$fa = I('get.fa');
		$ta = I('get.ta');
		if($fa && $ta)
			$where['a.addtime'] = array('between', array($fa, $ta)); // WHERE shop_price BETWEEN $fp AND $tp
		elseif ($fa)
			$where['a.addtime'] = array('egt', $fa);   // WHERE shop_price >= $fp
		elseif ($ta)
			$where['a.addtime'] = array('elt', $ta);   // WHERE shop_price <= $fp
		// 品牌
		$brandId = I('get.brand_id');
		if($brandId)
			$where['a.brand_id'] = array('eq', $brandId);
		/*************** 搜索结束 ******************/
                
           /***************** 排序 *****************/
		$orderby = 'a.id';      // 默认的排序字段 
		$orderway = 'desc';   // 默认的排序方式
		$odby = I('get.odby');
		if($odby)
		{
			if($odby == 'id_asc')
				$orderway = 'asc';
			elseif ($odby == 'price_desc')
				$orderby = 'shop_price';
			elseif ($odby == 'price_asc')
			{
				$orderby = 'shop_price';
				$orderway = 'asc';
			}
		}
            
		/*************** 翻页 ****************/
		// 取出总的记录数
		$count = $this->alias('a')->where($where)->count();
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
		->field('a.*,b.brand_name')
		->alias('a')
		->join('LEFT JOIN __BRAND__ b ON a.brand_id=b.id')
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
			$ret = uploadOne($_FILES['logo'], 'Goods', array(
				array(700, 700),
				array(500, 500),
				array(300, 300),
                                array(150, 150),
			));
			if($ret['ok'] == 1)
			{
				$data['logo'] = $ret['images'][0];
				$data['mbig_logo'] = $ret['images'][1];
                                $data['big_logo'] = $ret['images'][2];
				$data['mid_logo'] = $ret['images'][3];
				$data['sm_logo'] = $ret['images'][4];
			}
			else 
			{
				$this->error = $ret['error'];
				return FALSE;
			}
		}
                $data['goods_desc']=removeXSS($_POST['goods_desc']);
                $data['addtime']=date('Y-m-d H:i:s',time());
	}
	// 修改前
        
	protected function _before_update(&$data, $option)
	{
		if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0)
		{
			$ret = uploadOne($_FILES['logo'], 'Goods', array(
				array(700, 700),
				array(500, 500),
				array(300, 300),
                            array(150, 150),
			));
			if($ret['ok'] == 1)
			{
				$data['logo'] = $ret['images'][0];
				$data['mbig_logo'] = $ret['images'][1];
                                $data['big_logo'] = $ret['images'][2];
				$data['mid_logo'] = $ret['images'][3];
				$data['sm_logo'] = $ret['images'][4];
			}
			else 
			{
				$this->error = $ret['error'];
				return FALSE;
			}
			deleteImage(array(
				I('post.old_logo'),
                                I('post.old_mbig_logo'),
				I('post.old_big_logo'),
				I('post.old_mid_logo'),
				I('post.old_sm_logo'),
	
			));
		}
                  $data['goods_desc']=removeXSS($_POST['goods_desc']);
	}
        
        //添加后
        protected function _after_insert($data, $option)
	{
            $id = $option['where']['id'];   // 添加商品后的ID
		/************ 处理相册图片 *****************/
		if(isset($_FILES['pic']))
		{
			
		}
	
	}
	// 删除前
	protected function _before_delete($option)
	{
		$id = $option['where']['id'];   // 要删除的商品的ID
	}
	/************************************ 其他方法 ********************************************/
}