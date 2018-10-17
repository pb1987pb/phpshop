<?php
namespace Admin\Controller;
use Think\Controller;
class RoleController extends BaseController
{
    public function add()
    {
    	if(IS_POST)
    	{
            
    		$model = D('Role');
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

        // 查询出所有的权限列表
                 $parentModel = D('Privilege');
		$parentData = $parentModel->getTree();

        
		// 设置页面中的信息
		$this->assign(array(
                        'parentData' => $parentData,
			'_page_title' => '添加角色',
			'_page_btn_name' => '角色列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }
    public function edit()
    {
    	$id = I('get.id');
        $model = D('Role');
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

          
              // 查询出所有的权限列表
                 $parentModel = D('Privilege');
		$parentData = $parentModel->getTree();
                
                //获取当前角色拥有的权限id集合
                   $priroleModel=D('role_pri');
                $priroleData = $priroleModel
                   ->field('group_concat(pri_id) pris')
                   -> where(array(
                      'role_id'=>array('eq',$id)
                  ))->group('role_id')
                        ->find();
  
//                  dump($priroleData['pris']);
//                  exit;
		// 设置页面中的信息
		$this->assign(array(
                        'priroleData' => $priroleData['pris'],
                        'parentData' => $parentData,
			'_page_title' => '修改角色',
			'_page_btn_name' => '角色列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }
    public function delete()
    {
    	$model = D('Role');
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
    	$model = D('Role');
    	$data = $model->search();
    	$this->assign(array(
    		'data' => $data['data'],
    		'page' => $data['page'],
    	));

		// 设置页面中的信息
		$this->assign(array(
			'_page_title' => '角色列表',
			'_page_btn_name' => '添加角色',
			'_page_btn_link' => U('add'),
		));
    	$this->display();
    }
}