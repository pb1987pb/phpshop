<?php
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends Controller 
{
    public function add()
    {
    	if(IS_POST)
    	{
    		$model = D('Goods');
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
		// 设置页面中的信息
		$this->assign(array(
			'_page_title' => '添加商品',
			'_page_btn_name' => '商品列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }
    public function edit()
    {
    	   $id = I('get.id');
           $model = D('Goods');
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
		// 设置页面中的信息
		$this->assign(array(
                        'data'        =>  $data,
			'_page_title' => '修改商品',
			'_page_btn_name' => '商品列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }

    public function lst()
    {
    	$model = D('Goods');
    	$data = $model->search(5);
        // 设置页面中的信息
    	$this->assign(array(
            //设置分页和数据
    		'data' => $data['data'],
    		'page' => $data['page'],
            //设置模板数据，建议用_开头，好区分
                  '_page_title' => '商品列表',
	          '_page_btn_name' => '添加商品',
		'_page_btn_link' => U('add'),
    	));
    	$this->display();
    }
    
        public function delete()
	{
		$model = D('goods');
		if(FALSE !== $model->delete(I('get.id')))
			$this->success('删除成功！', U('lst'));
		else 
			$this->error('删除失败！原因：'.$model->getError());
	}
}