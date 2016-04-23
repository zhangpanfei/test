<?php
	/*
	   ---------------------------------------
	   简单案例 具体见 connect.qq.com
	*/

	//自己的网站登陆成功后回调地址
	$selfUrl="http://juche123.com";
	//申请的appid 和 appkey  申请网址 connect.qq.com
	$appID='101290312';
	$appKEY='6e9fbf11b849fa9cf017f7728a3ec0d9';
	//第一步，获取主要code ****************************************start*******************************
	//点击请求地址后 会跳转到QQ登陆页面  
	$url='https://graph.qq.com/oauth2.0/authorize';
	$data=array(
			'response_type' => 'code',	//固定
			'client_id'	=> $appID,	
			'redirect_uri'	=> $selfUrl,
			'scope'	=> 'get_user_info,list_album,upload_pic,do_like', //可获取的权限  不是必选  默认请求对接口get_user_info进行授权
			'state'		=> 'test',	//client端的状态值。用于第三方应用防止CSRF攻击，成功授权后回调时会原样带回

		);
	$get_query=$url.'?'.http_build_query($data);
	$str=<<<STR
		<script>
			window.open('{$get_query}','win','width=500px,height=500px');
		</script>
STR;
	//echo $str;die;
	//返回数据
	/*
		http://juche123.com/?code=E63811488100362D3FDDD05838BDF39B&state=test
	*/
	//*******************************第一步end************************************************

	//第二步****************************************************start*****************************************
	//拿到第一步获取的code 请求 第二步url 主要获取access_token
	$code='435891D72DAFAACCF8C1EB3648BD35A8';
	$url="https://graph.qq.com/oauth2.0/token";
	$data=array(
			'grant_type' => 'authorization_code',
			'client_id'  => $appID,
			'client_secret' => $appKEY,
			'code'	=> $code,
			'redirect_uri' => $selfUrl,
		);
	$str=http_build_query($data);
	$get_query=$url.'?'.http_build_query($data);
	$str=<<<STR
		<script>
			window.open('{$get_query}','win','width=500px,height=500px');
		</script>
STR;
	//echo $str;die;
	/*
		返回值

		access_token=A65AB6FAB4D3DA7CD5CBD3A159E92B68&expires_in=7776000&refresh_token=F97312418B5FB52B1DFD5C4A863AA96C
	*/
	//*************************************第二步end**************************************************

	//第三步********************************************start*****************************************
	//拿到第二步获取的 access_token 请求第三部 url  主要获取 
	$access_token='A65AB6FAB4D3DA7CD5CBD3A159E92B68';
	$url='https://graph.qq.com/oauth2.0/me';
	$data=array(
			'access_token'=>$access_token,
		);
	$get_query=$url.'?'.http_build_query($data);
	$str=<<<STR
		<script>
			window.open('{$get_query}','win','width=500px,height=500px');
		</script>
STR;
	echo $str;die;
	/*
		返回值
		
		callback( {"client_id":"101290312","openid":"B6D3F4F10D24F4AE3456A574020AEE15"} );
	*/
	//******************************end*********************************************************

	//$openID="B6D3F4F10D24F4AE3456A574020AEE15";
	//var_export($_GET);
	parse_str($str,$data);   //与http_bulid_query() 相反 将请求参数转为数组
	print_r($data);
	echo md5(uniqid(rand(), TRUE)); //用于 oauth2.0协议签名
	//无聊 玩玩
	$i=1;
go:	echo mt_rand();
	($i<10000) or die();
	$i++;
	goto go;	
?>