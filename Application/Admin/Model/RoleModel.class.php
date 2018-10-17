<?php
namespace Admin\Model;
use Think\Model;
class RoleModel extends Model 
{
	protected $insertFields = array('role_name');
	protected $updateFields = array('id','role_name');
	protected $_validate = array(
		array('role_name', 'require', '角色名称不能为空！', 1, 'regex', 3),
                array('role_name', '', '角色名称已经存在！', 1, 'unique', 3)
	);
	public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		if($role_name = I('get.role_name'))
			$where['role_name'] = array('like', "%$role_name%");
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		$data['data'] = $this->alias('a')
                        ->field('a.*,group_concat(c.pri_name) prinames')
                        ->join('left join pan_role_pri b on b.role_id = a.id
                                left join pan_privilege c on c.id = b.pri_id')
                        ->where($where)
                        ->group('a.id')
                        ->limit($page->firstRow.','.$page->listRows)->select();
//                dump($data);
//                exit;
		return $data;
	}
	// 添加后
	protected function _after_insert($data, $option)
	{
            
             $id = $data['id'];
             $pris=I('post.priids');
             $priroleModel=D('role_pri');
             foreach($pris as $k=>$v){
                 $priroleModel->add(array(
                      'pri_id'=>$v,
                         'role_id'=>$id
                 ) 
                         );
             }
	}
	// 修改前
	protected function _before_update(&$data, $option)
	{
            $id = $option['where']['id'];
             $priroleModel=D('role_pri');
             // 先删除所有的权限，在增加
               $priroleModel->where(array(
                      'role_id'=>$id
                  ))-> delete();
              $pris=I('post.priids');
            
             foreach($pris as $k=>$v){
                 $priroleModel->add(array(
                      'pri_id'=>$v,
                         'role_id'=>$id
                 ) 
                         );
             }
            
	}
	// 删除前
	protected function _before_delete($option)
	{
            $id=$option['where']['id'];
		if(is_array($id))
		{
			$this->error = '不支持批量删除';
			return FALSE;
		}
                // 删除角色前，先删除角色权限表
                  $priroleModel=D('role_pri');
                  $priroleModel->where(array(
                      'role_id'=>$id
                  ))-> delete();
                
	}
	/************************************ 其他方法 ********************************************/
}