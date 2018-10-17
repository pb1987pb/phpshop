<?php
namespace Admin\Controller;
use Think\Controller;
class GoodAttrController extends BaseController
{
    public function add()
    {
      $type_id=  I('get.type_id');
    	if(IS_POST)
    	{
               dump(I('post.'));
            exit;
    		$model = D('GoodAttr');
    		if($model->create(I('post.'), 1))
    		{
    			if($id = $model->add())
    			{
    				$this->success('添加成功！', U('lst?type_id='.$type_id));
    				exit;
    			}
    		}
    		$this->error('添加失败！原因：'.$model->getError());
    	}

		// 设置页面中的信息
		$this->assign(array(
			'_page_title' => '添加商品属性表',
			'_page_btn_name' => '商品属性表列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }
    public function edit()
    {
        $type_id=  I('get.type_id');
       
    	$id = I('get.id');
        $model = D('GoodAttr');
    	if(IS_POST)
    	{
    		
    		if($model->create(I('post.'), 2))
    		{
    			if($model->save() !== FALSE)
    			{
    				$this->success('修改成功！', U('lst?type_id='.$type_id));
    				exit;
    			}
    		}
    		$this->error('修改失败！原因：'.$model->getError());
    	}
    	$data = $model->find($id);
        
    	$this->assign('data', $data);

		// 设置页面中的信息
		$this->assign(array(
			'_page_title' => '修改商品属性表',
			'_page_btn_name' => '商品属性表列表',
			'_page_btn_link' => U('lst?type_id='.$type_id),
		));
		$this->display();
    }
    public function delete()
    {
        $type_id=  I('get.type_id');
    	$model = D('GoodAttr');
    	if($model->delete(I('get.id', 0)) !== FALSE)
    	{
    		$this->success('删除成功！', U('lst?type_id='.$type_id));
    		exit;
    	}
    	else 
    	{
    		$this->error('删除失败！原因：'.$model->getError());
    	}
    }
    public function lst()
    {
    	$model = D('GoodAttr');
        $type_id=I('get.type_id');
    	$data = $model->search();
    	$this->assign(array(
    		'data' => $data['data'],
    		'page' => $data['page'],
    	));

		// 设置页面中的信息
		$this->assign(array(
			'_page_title' => '商品属性表列表',
			'_page_btn_name' => '添加商品属性表',
			'_page_btn_link' => U('add?type_id='.$type_id),
		));
    	$this->display();
    }
}