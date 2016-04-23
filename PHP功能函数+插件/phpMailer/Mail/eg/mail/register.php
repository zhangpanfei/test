<?php
	include_once './Mail.class.php';
	if($_GET['act']=='register'){
		$username=$_POST['username'];
		$password=md5($_POST['password']);
		$question=$_POST['question'];
		$answer=$_POST['answer'];
		$vaildate=uniqid();
		$email=$_POST['email'];
		$mysqli=new mysqli('127.0.0.1','root','admin','a_1');
		$mysqli->query("insert into user set username='$username',password='$password',question='$question',answer='$answer',validate='$vaildate',email='$email'");
		if(!$mysqli->affected_rows){
			die('注册失败');
		}
		$id=$mysqli->insert_id;
		$mail=new mail();
		$HTML=<<<HTML
		<meta charset='utf-8'>{$username},你好,请点击<a href='login.php?act=yanzheng&id={$id}&key={$vaildate}'>这里</a>进行验证
HTML;
		file_put_contents('mail.html',$HTML);
		/*if($mail::send('公司','注册验证',$HTML,$email)){
			echo '注册成功';
		}else{
			echo 'error';
		}*/
	}
?>