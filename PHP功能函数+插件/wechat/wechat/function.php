<?php
	function  jiqiren($keyword){
			$url='http://www.niurenqushi.com/app/simsimi/ajax.aspx';
			$ch=curl_init();
			curl_setopt($ch,CURLOPT_URL,$url);
			//捕获url响应信息不输出
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			//设置请求头信息
			curl_setopt($ch,CURLOPT_HEADER,0);
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false );
			curl_setopt($ch,CURLOPT_REFERER,'http://www.niurenqushi.com/app/simsimi/');
			//设置传输post数组
			$data = array(
			'txt'=>$keyword
			);
			//设置开启POST请求
			curl_setopt($ch,CURLOPT_POST,1);
			//传输参数值
			curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
			//3、执行curl
			$contentStr = curl_exec($ch);
			//4、关闭句柄
			curl_close($ch);
			return $contentStr;

}
?>