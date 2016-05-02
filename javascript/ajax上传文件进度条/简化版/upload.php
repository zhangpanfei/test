<?php
	header("Content-Type:text/html;charset=utf-8");
	//判断是否有文件上传
	$uploadFile=$_FILES['fileName'];
	if(empty($uploadFile))exit("没有文件被上传");

	$uploadFileTemp=$uploadFile['tmp_name'];//文件临时名
	$uploadFileName=$uploadFile['name'];//文件名

	//上传错误处理
	if(!is_uploaded_file($uploadFileTemp))exit('上传失败');

	//生成文件保存目录
	$fileDir='./upload';
	if(!is_dir($fileDir))mkdir($fileDir,0777,true);

	//生成文件名
	$fileName=uniqid().strrchr($uploadFileName,'.');

	//拼接文件路径
	$filePath=$fileDir.'/'.$fileName;

	//移动临时文件
	if(!move_uploaded_file($uploadFileTemp,$filePath))exit('上传失败');

	//上传成功后文件信息
	$html=<<<HTML
		成功上传了:{$uploadFileName}<br>
		服务器保存的路径为:{$filePath}
HTML;
	echo $html;
?>