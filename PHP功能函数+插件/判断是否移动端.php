<?php
	if(!isMobile()){
		return false;
	}else{
		echo 'is mobile';
	}
	function isMobile(){
        // �����HTTP_X_WAP_PROFILE��һ�����ƶ��豸
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))return true;
        // ���via��Ϣ����wap��һ�����ƶ��豸,���ַ����̻����θ���Ϣ
        if (isset ($_SERVER['HTTP_VIA']))return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        // �Բз����ж��ֻ����͵Ŀͻ��˱�־,�������д����
        if (isset ($_SERVER['HTTP_USER_AGENT'])){
            $clientkeywords = array ('iphone', 'android','mobile' );
            // ��HTTP_USER_AGENT�в����ֻ�������Ĺؼ���
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))return true;
        }
        // Э�鷨����Ϊ�п��ܲ�׼ȷ���ŵ�����ж�
        if (isset ($_SERVER['HTTP_ACCEPT']))
        {
            // ���ֻ֧��wml���Ҳ�֧��html��һ�����ƶ��豸
            // ���֧��wml��html����wml��html֮ǰ�����ƶ��豸
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) return true;
        }
        return false;
    }
?>