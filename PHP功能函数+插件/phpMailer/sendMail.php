<?php
	require("Mail/class.phpmailer.php");    
    function smtp_mail($mailHost,$fromMail,$password,$formName,$toMail,$toName,$subject,$mailBody){    
        $mail = new PHPMailer();    
        $mail->IsSMTP();                  // send via SMTP    
        $mail->Host = $mailHost;   // SMTP servers    
        $mail->SMTPAuth = true;           // turn on SMTP authentication    
        $mail->Username = $fromMail;     // SMTP username  注意：普通邮件认证不需要加 @域名    
        $mail->Password = $password; // SMTP password    
        $mail->From = $fromMail;      // 发件人邮箱    
        $mail->FromName =  $formName;  // 发件人    

        $mail->CharSet = "utf-8";   // 这里指定字符集！    
        $mail->Encoding = "base64";    
        $mail->AddAddress($toMail,$toName);  // 收件人邮箱和姓名    
        //$mail->AddReplyTo("yourmail@yourdomain.com","yourdomain.com"); //应答邮箱地址   
        //$mail->WordWrap = 50; // set word wrap 换行字数    
        //$mail->AddAttachment("/var/tmp/file.tar.gz"); // attachment 附件    
        //$mail->AddAttachment("1.jpg"); // attachment 附件    
        //$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    
        $mail->IsHTML(true);  // send as HTML    
        // 邮件主题    
        $mail->Subject = $subject;    
        // 邮件内容    
        $mail->Body = $mailBody;                                                                          
        $mail->AltBody ="text/html";    
        if(!$mail->Send())    
        {    
            echo "邮件发送有误 <p>";    
            echo "邮件错误信息: " . $mail->ErrorInfo;    
            exit;    
        }    
        else {    
            echo "$toName 邮件发送成功!<br />";    
        }    
    }    
    // 参数说明(邮箱服务器地址, 发件人邮箱, 发件人密码, 发件人名字, 收件人邮箱,收件人名字,邮件主题,邮件内容)
    $mailHost='smtp.qq.com';
    $fromMail='2712504486@qq.com';
    $password='ytq123';
    $formName='管理员';
    $toMail='1009928990@qq.com';
    $toName='zpf';
    $subject='测试';
    $mailBody='测试一下';    
    smtp_mail($mailHost,$fromMail,$password,$formName,$toMail,$toName,$subject,$mailBody);
?>