<?php
namespace Home\Model;
use Think\Model;
class MemberModel extends Model 
{
         // 注册的时候 和  登录的时候需要用的 表单参数 ，   注册的时候还有个  must_click ，协议
	protected $insertFields = array('username','password','repassword','chkcode','must_click');
        
	protected $updateFields = array('id','password','repassword');
        
        // 注册和修改会员信息的时候添加的表单验证
        // 这里有几个地方注意 ：  1，只要注册的时候一定要  must_click（同意协议）
                        //     2,密码和确认密码不为null 只是在 注册 的时候才会验证 ,修改会员的信息的时候一般不需要，空代表不修改
                        //  3,会员登录用户名不能修改
        
	protected $_validate = array(
                array('must_click', 'require', '必须同意注册协议！', 1, 'regex', 1),
               array('chkcode', 'require', '验证码不能为空！', 1, 'regex', 1),
		array('chkcode', 'check_verify', '验证码不正确！', 1, 'callback'),
		array('username', 'require', '用户名不能为空！', 1, 'regex', 1),
                array('username', '', '用户名已经存在！', 1, 'unique', 1),
		array('username', '1,30', '用户名的值最长不能超过 30 个字符！', 1, 'length', 1),
		array('password', 'require', '密码不能为空！', 1, 'regex', 1), 
                array('repassword', 'require', '确认密码不能为空！', 1, 'regex', 1), 
                array('repassword','password','确认密码不正确',1,'confirm',3),
             
	);
        
        // 下面这个是登录的时候自定义的错误，必须使用 public，要不然的在登录的控制器里面是访问不到这个字段的。
         // 登录的时候，只需要 用户名，密码和验证码
        public $_login_validate  = array(
		array('username', 'require', '用户名不能为空！', 1, 'regex', 3),
		array('password', 'require', '密码不能为空！', 1, 'regex', 1), 
//                array('chkcode', 'require', '验证码不能为空！', 1, 'regex', 1), 
//                array('chkcode','check_verify','验证码错误',1,'callback')
                
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
                $this->error='用户名或者密码不正确';
                return false;
            }
            
            else {
              if($user['password']!=md5($password))
                  {
                  // 密码不正确
                   $this->error='用户名或者密码不正确';
                return false;
              }
           else {
                 //用户名和密码都正确,那么就是把数据保存到 session ,这里和后台必须保存的内容不能一样
               // 因为此时的sessid一样，保存的是一样的，那后台就会被覆盖
                  $this->setSession($user);
                 
                  // 调取购物车中的临时数据，存储到数据库中
                 $cartModel=D('cart');
                 $cartModel->moveDataToDb();
                  
                if($isMember){ 
                    //记住密码,那么就加密存储到cookie,保存一个星期
                    $salt=C('salt');
                    cookie('m_id',md5($user['id'].$salt),3600*24*7);
                    cookie('m_pwd',md5($user['password'].$salt),3600*24*7);
                }
                
                return true;
               
             }
                
            }
            
        }
        
        
        
        
        
        /**
         *  前台存储session
         */
        public function setSession($user)
        {
                session('m_id',$user['id']);
                session('m_username',$user['username']);
                
                //  这个有需要最好是存储一个会员等级，在买东西的时候可以核算价格优惠
                 $memberlevelModel=D('member_level');
                 $level=$memberlevelModel->field('id')
                         ->where(array(
                             'jifen_bottom'=>array('elt',$user['jifen']),
                             'jifen_top'=>array('egt',$user['jifen'])
                         ))->find();
              
                 session('memberlevel',$level['id']);
        }

                /**
         * 
         * 自动登录
         */
        public function autoLogin()
          {
             $id=cookie('m_id');
            $pwd=cookie('m_pwd');
            if(!$id||!$pwd){
                return FALSE;
            }
          
          $salt=C('salt'); // 这个是配置的混淆的密钥匙
          // 但是下面这个查询没有用到索引，很慢 ,而且获取到的是 二维数组
//          $result2=  $this->query("select * from pan_member where md5(concat(id,'$salt')) ='$id' and md5(concat(password,'$salt')) ='$pwd'");
         
          //这样子使用 exp来获取到的数值
          $user=$this->where(array(
              ''=>array('exp',"md5(concat(id,'$salt')) ='$id' and md5(concat(password,'$salt')) ='$pwd'")
          ))->find();
           
          if($user){
              // 能查询出来数据，就是成功
               //用户名和密码都正确,那么就是把数据保存到 session 
              $this->setSession($user);  
               // 调取购物车中的临时数据，存储到数据库中
                 $cartModel=D('cart');
                 $cartModel->moveDataToDb();
                return  true ;     
          } 
             // 失败的话，那么此时清空 cookie
               cookie('m_id',null);
               cookie('m_pwd',null);
            return false;

            
        }

        public function logout()
     {
         //退出就是清空session 
             cookie('m_id',null);
               cookie('m_pwd',null);
         session(null);
     }
        
        protected function _before_insert(&$data, $option)
	{
            //  增加会员之前，需要md5 加密
		$data['password'] = md5($data['password']);
	}

      // 添加会员后,直接就登录成功
	protected function _after_insert($data, $option)
	{
             $id = $data['id'];
//              $memData = $this->find($id);
//                 session('m_id',$memData['id']);
//                session('m_username',$memData['username']);

	}
        
	
	/************************************ 其他方法 ********************************************/
}