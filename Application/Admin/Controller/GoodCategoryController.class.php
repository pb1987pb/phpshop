<?php
namespace Admin\Controller;
use Think\Controller;
class GoodCategoryController extends BaseController
{
    public function add()
    {
    	if(IS_POST)
    	{
             
//             exit;
    		$model = D('GoodCategory');
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
		$parentModel = D('GoodCategory');
		$parentData = $parentModel->getTree();
		$this->assign('parentData', $parentData);

		// 设置页面中的信息
		$this->assign(array(
			'_page_title' => '添加商品分类表',
			'_page_btn_name' => '商品分类表列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }
    public function edit()
    {
    	$id = I('get.id');
        $model = D('GoodCategory');
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
		$parentModel = D('GoodCategory');
		$parentData = $parentModel->getTree();
		$children = $parentModel->getChildren($id);
		$this->assign(array(
			'parentData' => $parentData,
			'children' => $children,
		));

		// 设置页面中的信息
		$this->assign(array(
			'_page_title' => '修改商品分类表',
			'_page_btn_name' => '商品分类表列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }
    public function delete()
    {
    	$model = D('GoodCategory');
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
    	$model = D('GoodCategory');
		$data = $model->getTree();
    	$this->assign(array(
    		'data' => $data,
    	));

		// 设置页面中的信息
		$this->assign(array(
			'_page_title' => '商品分类表列表',
			'_page_btn_name' => '添加商品分类表',
			'_page_btn_link' => U('add'),
		));
    	$this->display();
    }
}