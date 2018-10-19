<?php
/* *
 * 功能：即时到账交易接口接入页
 * 版本：3.3
 * 修改日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************注意*************************
 * 如果您在接口集成过程中遇到问题，可以按照下面的途径来解决
 * 1、商户服务中心（https://b.alipay.com/support/helperApply.htm?action=consultationApply），提交申请集成协助，我们会有专业的技术工程师主动联系您协助解决
 * 2、商户帮助中心（http://help.alipay.com/support/232511-16307/0-16307.htm?sh=Y&info_type=9）
 * 3、支付宝论坛（http://club.alipay.com/read-htm-tid-8681712.html）
 * 如果不想使用扩展功能请把扩展功能参数赋空值。
 */

require_once("alipay.config.php");
require_once("lib/alipay_submit.class.php");

/**************************请求参数,在生成支付按钮的时候需要的一些参数**************************/

        //支付类型 ，必填，不能修改*****
        $payment_type = "1";
       //必填
        
        //服务器异步通知页面路径 ： 我们用来接收消息的地址，支付宝告诉我们接收消息
        //需http://格式的完整路径，不能加?id=123这类自定义参数
        $notify_url = "http://www.shop.com/index.php/Home/Order/receive";
        //必填

        //页面跳转同步通知页面路径 ： 支付成功之后跳转的页面，付款跳转到支付宝，成功之后跳回来的页面
         //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
        $return_url = "http://www.shop.com/index.php/Home/Order/pay_success";
       

        //商户订单号，这个是在函数的参数里面传递过来的，商户网站订单系统中唯一订单号
        $out_trade_no = $orderId;
        //必填***

        //订单名称，这个是随便起，但是不能重复，所以这里加了一个 $orderId ，这个可以根据自己定义的规则生成名字
        $subject = 'shop网定单名称-'.$orderId;
        //必填****
        
        $orderModel = D('order');
        $tp = $orderModel->field('total_price')->find($orderId);

        //付款金额
        $total_fee = $tp['total_price'];
        //必填

        //订单描述，随表写，不是必填，
        $body = 'shop网定单名称-'.$orderId;
        
        //商品展示地址 ： 就是在支付的时候看下订单中有哪些商品，定单详细页
        $show_url = 'http://www.shop.com/index.php/Home/Order/view/id/'.$orderId;
        //需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html

        //防钓鱼时间戳
        $anti_phishing_key = "";
        //若要使用请调用类文件submit中的query_timestamp函数

        //客户端的IP地址
        $exter_invoke_ip = "";
        //非局域网的外网IP地址，如：221.0.0.1


/************************************************************/

//构造要请求的参数数组，无需改动,这个就是把上面的参数进行加密
$parameter = array(
		"service" => "create_direct_pay_by_user",
		"partner" => trim($alipay_config['partner']),
		"seller_email" => trim($alipay_config['seller_email']),
		"payment_type"	=> $payment_type,
		"notify_url"	=> $notify_url,
		"return_url"	=> $return_url,
		"out_trade_no"	=> $out_trade_no,
		"subject"	=> $subject,
		"total_fee"	=> $total_fee,
		"body"	=> $body,
		"show_url"	=> $show_url,
		"anti_phishing_key"	=> $anti_phishing_key,
		"exter_invoke_ip"	=> $exter_invoke_ip,
		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
);

//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
// 下面这个就是生成按钮，生成按钮的名称可以通过外面传递。默认传递的是 "去支付宝支付" ,然后生成按钮返回
return $alipaySubmit->buildRequestForm($parameter, "get", $btnName);
