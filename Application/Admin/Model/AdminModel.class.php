<?php
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model 
{
	protected $insertFields = array('username','password','repassword','chkcode');
	protected $updateFields = array('id','username','password','repassword');
	protected $_validate = array(
		array('username', 'require', '用户名不能为空！', 1, 'regex', 3),
                array('username', '', '用户名已经存在！', 1, 'unique', 3),
		array('username', '1,30', '用户名的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('password', 'require', '密码不能为空！', 1, 'regex', 1), 
                array('repassword', 'require', '确认密码不能为空！', 1, 'regex', 1), 
                array('repassword','password','确认密码不正确',0,'confirm')
                
	);
        
        // 下面这个必须要注意，必须使用 public，要不然的在登录的控制器里面是访问不到这个字段的。
        public $_login_validate  = array(
		array('username', 'require', '用户名不能为空！', 1, 'regex', 3),
		array('password', 'require', '密码不能为空！', 1, 'regex', 1), 
                array('chkcode', 'require', '验证码不能为空！', 1, 'regex', 1), 
                array('chkcode','check_verify','验证码错误',1,'callback')
                
	);
        
        // 验证验证码是否正确
        function check_verify($code,$id = ''){
            $verify = new \Think\Verify();
            return $verify->check($code,$id);
        }
        
        /**
         *  验证登录,$isMember 是是否记住登录密码
         */
        public function  checkLogin($isMember=FALSE)
        {
     
            // 从模型中获取用户名和密码
            // 这里面其实和 I('post.') 获取来的是一样的，只是因为这个是模型本身有的，所有可以直接这样子获取到值
            $userName=$this->username;
            $password=$this->password;
            
            //  根据用户名来查找是否有该用户
          $user=  $this->where(array(
                'username'=>$userName
            ))->find();
          
            if(!$user){
                $this->error='用户名不正确';
                return false;
            }  else {
              if($user['password']!=md5($password)){
                  // 密码不正确
                   $this->error='密码不正确';
                return false;
              }
           else {
                 //用户名和密码都正确,那么就是把数据保存到 session 
                session('id',$user['id']);
                session('username',$user['username']);
                
                //判断是否记住密码，记住了那么就存储cookie
                if(I('post.member')){ 
                    //记住密码,那么就加密存储到cookie,保存一个星期
                    $salt=C('salt');
                    cookie('id',md5($user['id'].$salt),3600*24*7);
                    cookie('pwd',md5($user['password'].$salt),3600*24*7);
                }
                
                return true;
               
             }
                
            }
            
        }
        
        /**
         * 
         * 自动登录
         */
        public function autoLogin()
          {
              $id=cookie('id');
            $pwd=cookie('pwd');
            if(!$id||!$pwd){
                return FALSE;
            }
          
          $salt=C('salt'); // 这个是配置的混淆的密钥匙
          // 但是下面这个查询没有用到索引，很慢
          $result=  $this->query("select * from pan_admin where md5(concat(id,'$salt')) ='$id' and md5(concat(password,'$salt')) ='$pwd'");
         
          if($result){
              // 能查询出来数据，就是成功
               //用户名和密码都正确,那么就是把数据保存到 session 
                session('id',$result[0]['id']);
                session('username',$result[0]['username']);
                return  true ;
               
          } 
             // 失败的话，那么此时清空 cookie
               cookie('id',null);
               cookie('pwd',null);
            return false;

            
        }

        public function loginOut()
     {
         //退出就是清空session 
             cookie('id',null);
               cookie('pwd',null);
         session(null);
     }
        

        public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		if($username = I('get.username'))
			$where['username'] = array('like', "%$username%");
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		$data['data'] = $this->alias('a')
                        ->field('a.*,group_concat(c.role_name) roles')
                        ->join('left join pan_admin_role b on b.admin_id=a.id
                             left join pan_role c on c.id = b.role_id')
                        ->where($where)
                        ->group('a.id')
                        ->limit($page->firstRow.','.$page->listRows)->select();
      
		return $data;
	}
        // 添加前
	protected function _before_insert(&$data, $option)
	{
       
             $data['password']=md5($data['password']);
       
	}
	// 添加后
	protected function _after_insert($data, $option)
	{
             $id = $data['id'];
             // 添加之后，添加管理员角色
             $adroleModel=D('admin_role');
             $roles=I('post.roleids');
             foreach($roles as $k => $v){
                 $adroleModel->add(array(
                     'role_id' => $v,
                     'admin_id'=>$id
                 ));
             }
	}
	// 修改前
	protected function _before_update(&$data, $option)
	{
            $id = $option['where']['id'];  // 要修改的商品的ID

            // 在修改密码之前，这个需要去判断一下是否是空，是空就不修改，直接删除这个字段，不是空，才去修改
            if(!$data['password'])
                unset ($data['password']);
            else{
                 $data['password']=md5($data['password']);
                 
                 }
            // 修改管理员之前，先删除相应的管理员和角色列表
                 
                   $adroleModel=D('admin_role');
                   $adroleModel->where(array(
                       'admin_id' => array('eq',$id)
                   ))->delete();
             $roles=I('post.roleids');
             foreach($roles as $k => $v){
                 $adroleModel->add(array(
                     'role_id' => $v,
                     'admin_id'=>$id
                 ));
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
                if($id==1){
                    // 等于1就是root，也就是超级管理员
                    $this->error='这个是系统管理员，是不能删除的';
                    return FALSE;
                }
                // 删除管理员的时候，把管理员所有的角色也删除
                    $adroleModel=D('admin_role');
                   $adroleModel->where(array(
                       'admin_id' => array('eq',$id)
                   ))->delete();
	}
	/************************************ 其他方法 ********************************************/
}