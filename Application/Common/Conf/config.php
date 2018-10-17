<?php
return array(
	//'配置项'=>'配置值'
        //数据库配置  
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'shopshop',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'pan_',    // 数据库表前缀,
     'DEFAULT_FILTER'        =>  'trim,htmlspecialchars', // 默认参数过滤方法 用于I函数...
    //关于上传图片的一些配置
    'IMAGE_CONFIG'           =>array(
        'maxSize' => 1024*1024,
    	'exts' => array('jpg', 'gif', 'png', 'jpeg'),
        'rootPath'          => './Public/Uploads/', //相对服务器根目录地址
        'viewPath'          => '/Public/Uploads/'  //相对网站根目录地址，网站用的。
    ),
    // cookie 加密的盐
    'salt' => 'pan',
    // 显示跟踪信息
//    'SHOW_PAGE_TRACE' => true  ,// 默认是false,开启则改为 true 
    // 缓存存储到  memcache
    //    S(array(    
    //        'type'=>'memcache',   
    //        'host'=>'192.168.1.102', 
    //        'port'=>'11211',  
    //        'prefix'=>'think',  
    //        'expire'=>60
    //        )),

);