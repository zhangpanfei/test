<?php
	include_once './Mail/class.phpmailer.php';
	class Mail{
		static function send($FromName,$Subject,$MsgHTML,$AddAddress,$AddAttachment=''){
			$mail=new PHPMailer();
			/*服务器相关信息*/
			$mail->IsSMTP();                        //设置使用SMTP服务器发送
			$mail->SMTPAuth   = true;               //开启SMTP认证
			$mail->Host       = 'smtp.163.com';   	    //设置 SMTP 服务器,自己注册邮箱服务器地址
			$mail->Username   = 'phpdaxia001';  		//发信人的邮箱名称
			$mail->Password   = 'php1234';          //发信人的邮箱密码
			/*内容信息*/
			$mail->IsHTML(true); 			         //指定邮件格式为：html
			$mail->CharSet    ="UTF-8";			     //编码
			$mail->From       = 'phpdaxia001@163.com';	 		 //发件人完整的邮箱名称
			$mail->FromName   = $FromName;			 //发信人署名
			$mail->Subject    = $Subject;  			 //信的标题
			$mail->MsgHTML($MsgHTML);  				 //发信内容
			$mail->AddAttachment($AddAttachment);	     //附件
			/*发送邮件*/
			$mail->AddAddress($AddAddress);  			 //收件人地址
			//使用send函数进行发送
			if($mail->Send()) {
				return true;
			} else {
				return false;
			}

		}
	}
?>