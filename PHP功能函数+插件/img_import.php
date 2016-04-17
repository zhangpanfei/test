<?php
	/*
	*@para img_url string 图片url
	*@para img_dir string 图片文件夹
	*return 成功:图片路径 失败:false
	*/
	function get_img($img_url,$img_dir){
		//获取图片后缀
		$img_suffix=substr($img_url,strrpos($img_url,'.'));
		//获取图片字符串
		$img_str=file_get_contents($img_url);
		//唯一图片名
		$img_name=uniqid().$img_suffix;

		if(!is_dir($img_dir)){
			mkdir($img_dir,0777,true);
		}
		//图片全路径
		$img_path=$img_dir.'/'.$img_name;
		//保存图片
		$res=file_put_contents($img_path,$img_str);
		if(!$res){
			return false;
		}else{
			return $img_path;
		}
	}
	
	//测试
	$img_url='http://baike.soso.com/p/20090711/20090711100323-2421'.mt_rand(1000,9999).'.jpg';
	$img_dir='d:/imgage_test';
	$img_path=get_img($img_url,$img_dir);
	echo '<mate charset="utf-8">图片已存入'.$img_path."\n";
?> 