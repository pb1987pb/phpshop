<?php
return array(
	//'配置项'=>'配置值'
        'HTML_CACHE_ON'     =>    FALSE, // 开启静态缓存',在开发阶段，这个最好是关闭
    'HTML_CACHE_TIME'   =>    60,   // 全局静态缓存有效期（秒）
    'HTML_FILE_SUFFIX'  =>    '.shtml', // 设置静态缓存文件后缀
    // 这个是哪个模块生成静态页
    'HTML_CACHE_RULES'  =>   array(  
        'Index:index' =>   array('index', 86400),//首页生成index.shtml一天的时间
        'Goods:detail' =>  array('good-{id}', 86400),//首页生成index.shtml一天的时间
        )
);