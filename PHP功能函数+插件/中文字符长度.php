<?php
	function getLen(string $str){
		$len=strlen($str);
		if(!$len)return 0;
		$count=0;
		for($i=0;$i<$len;$i++){
			if(ord($str{$i})>=0x80){
				$i+=2;		//utf-8 3个字节一个中文
				//++$i;			//gbk 2个字节一个中文
			}
			++$count;
		}
		return $count;
	}

	$str='中国so好！';
	echo getLen($str);
?>