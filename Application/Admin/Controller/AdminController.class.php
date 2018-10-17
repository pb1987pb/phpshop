<?php
namespace Admin\Controller;
use Think\Controller;
class AdminController extends BaseController
{
    public function add()
    {
    	if(IS_POST)
    	{
//            dump(I('post.'));exit;
    		$model = D('Admin');
    		if($model->create(I('post.'), 1))
    		{
    			if($id = $model->add())
    			{
    				$this->success('添加成功！', U('lst'));
    				exit;
    			}
    		}
    		$this->error('添加失败！原因：'.$model->getError());
    	}
       //  查询出所有的角色
         $roleModel = D('Role');
         $roleData=$roleModel
         ->select();
        
		// 设置页面中的信息
		$this->assign(array(
                        'roleData' =>  $roleData,
			'_page_title' => '添加管理员',
			'_page_btn_name' => '管理员列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }
    public function edit()
    {
    	$id = I('get.id');
        $model = D('Admin');
    	if(IS_POST)
    	{
    		
    		if($model->create(I('post.'), 2))
    		{
    			if($model->save() !== FALSE)
    			{
    				$this->success('修改成功！', U('lst'));
    				exit;
    			}
    		}
    		$this->error('修改失败！原因：'.$model->getError());
    	}
    	$data = $model->find($id);
    	$this->assign('data', $data);

           //  查询出所有的角色
         $roleModel = D('Role');
         $roleData=$roleModel->alias('a')
                 ->field('a.*,b.role_id role_id')
                 ->join('left join pan_admin_role b on (b.role_id =a.id and b.admin_id='.$id.')')
         ->select();
        
		// 设置页面中的信息
		$this->assign(array(
                        'roleData' => $roleData,
			'_page_title' => '修改管理员',
			'_page_btn_name' => '管理员列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }
    public function delete()
    {
    	$model = D('Admin');
    	if($model->delete(I('get.id', 0)) !== FALSE)
    	{
    		$this->success('删除成功！', U('lst'));
    		exit;
    	}
    	else 
    	{
    		$this->error('删除失败！原因：'.$model->getError());
    	}
    }
    public function lst()
    {
    	$model = D('Admin');
    	$data = $model->search();
    	$this->assign(array(
    		'data' => $data['data'],
    		'page' => $data['page'],
    	));

		// 设置页面中的信息
		$this->assign(array(
			'_page_title' => '管理员列表',
			'_page_btn_name' => '添加管理员',
			'_page_btn_link' => U('add'),
		));
    	$this->display();
    }
}