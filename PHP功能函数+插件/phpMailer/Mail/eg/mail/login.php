<?php
	header('content-type:text/html;charset=utf-8');
	$act=isset($_GET['act'])?$_GET['act']:die();
	$mysqli=new mysqli('127.0.0.1','root','admin','a_1');
	if($act=='yanzheng'){
		mkdir(rand(0,99999));
		$id=$_GET['id'];
		$key=$_GET['key'];
		$sql='select active from user where id='.$id.' and validate="'.$key.'"';
		$res=$mysqli->query($sql);
		$row=$res->fetch_assoc();
		if($row['active']!=0){
			die('已经验证');
		}else{
			$sql='update user set active=1 where id='.$id.' and validate="'.$key.'"';
			if($mysqli->query($sql)){
				echo 'ok';//die;
			}
		}
	}elseif($act=='login'){
		$username=$_POST['username'];
		$res=$mysqli->query('select password from user where username="'.$username.'"');
		if($id=$res->fetch_assoc()){
			$sql='select active from user where username="'.$username.'"';
			$res1=$mysqli->query($sql);
			$row=$res1->fetch_assoc();
			if($row['active']!=1){
				die('没有验证');
			}
			$password=$id['password'];
			if(md5($_POST['password'])==$password){
				echo '登陆成功';
			}else{
				echo '密码错误';
			}
		}else{
			echo '用户名不存在';
		}
	}elseif($act=='zhao'){
		$sql='select distinct question from user';
		$res=$mysqli->query($sql);
		while($row=$res->fetch_assoc()){
			$question[]=$row['question'];
		}
		include_once('zhao.html');
	}elseif($act=='zhaohui'){
		$username=addslashes($_POST['username']);
		$wenti=$_POST['wenti'];
		$answer=addslashes($_POST['answer']);
		$sql="select id from user where username='$username' and question='$wenti' and answer='$answer'";
		$res=$mysqli->query($sql);
		if($row=$res->fetch_assoc()){
			$password=mt_rand(100,999);
			$_password=md5($password);
			$id=$row['id'];
			$mysqli->query("update user set password='$_password' where id=$id limit 1");
			file_put_contents('pass.txt',$password);
			echo '找回';
		}else{
			echo '信息有误';
		}
	}
?>