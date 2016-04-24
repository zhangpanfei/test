<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "zpf");
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
$wechatObj->responseMsg();
class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		/*$GLOBALS["HTTP_RAW_POST_DATA"]='
				<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>1351776360</CreateTime>
<MsgType><![CDATA[location]]></MsgType>
<Location_X>23.134521</Location_X>
<Location_Y>113.358803</Location_Y>
<Scale>20</Scale>
<Label><![CDATA[位置信息]]></Label>
<MsgId>1234567890123456</MsgId>
</xml> 
		';*/


		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                define('F',$postObj->FromUserName);
                define('T',$postObj->ToUserName);
				$msgType=$postObj->MsgType;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";             
				if(!empty( $msgType ))
                {
					$this->receiveMsg($postObj);exit;
              		$msgType = "text";
                	$contentStr = "";
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }

        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

	private function receiveMsg($msg){
		$msgType=$msg->MsgType;
		$msgEvent=$msg->Event;
		$tpl='
			<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%d</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>
		';
		$mtpl='
			<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%d</CreateTime>
<MsgType><![CDATA[music]]></MsgType>
<Music>
<Title><![CDATA[%s]]></Title>
<Description><![CDATA[%s]]></Description>
<MusicUrl><![CDATA[%s]]></MusicUrl>
<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>

</Music>
</xml>
		';
		$ntpl='
		<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%d</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>%d</ArticleCount>
<Articles>
%s
</Articles>
</xml> 
		';
		$ltpl='

		';
		if($msgType=='text'){
			if($msg->Content=='yue'){
				$url='http://zshop01.duapp.com/Public/music/a.mp3';
				printf($mtpl,F,T,time(),'再见','分手季节',$url,$url);
				exit;
			}elseif($msg->Content=='wen'){
				$count=3;
				$str='';
				$pic='http://zshop01.duapp.com/Public/Home/images/logo.gif';
				$url='http://zshop01.duapp.com';
				$url='http://www.baidu.com';
				for($i=0;$i<$count;$i++){
					$title='图文'.($i+1);
					$desc='描述'.($i+1);
					$str.=<<<ITEM
						<item>
							<Title><![CDATA[$title]]></Title> 
							<Description><![CDATA[$desc]]></Description>
							<PicUrl><![CDATA[$pic]]></PicUrl>
							<Url><![CDATA[$url]]></Url>
						</item>
ITEM;
				}
				printf($ntpl,F,T,time(),$count,$str);
				return;
			}elseif($msg->Content=='link'){
				
			}elseif($msg->Content=='zpf'){
				printf($tpl,F,T,time(),'老大您好');
				return;
			}
			$url='http://www.xiaohuangji.com/ajax.php';
			$url='http://www.niurenqushi.com/app/simsimi/ajax.aspx';
			$ch=curl_init();
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_REFERER,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_POST,1);
			$data=array('txt'=>$msg->Content);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
			$str=curl_exec($ch);
			curl_close($ch);
			echo sprintf($tpl,F,T,time(),$str);
		}elseif($msgType=='image'){
			echo sprintf($tpl,F,T,time(),'图片');
		}elseif($msgType=='voice'){
			echo sprintf($tpl,F,T,time(),'声音');
		}elseif($msgType=='event'&&$msgEvent=='subscribe'){
			printf($tpl,F,T,time(),'感谢您的关注');
		}elseif($msgType=='music'){
			printf($tpl,F,T,time(),'听听音乐');
		}elseif($msgType=='location'){
			$url='http://api.map.baidu.com/telematics/v3/reverseGeocoding?location='.$msg->Location_Y.','.$msg->Location_X.'&coord_type=gcj02&ak=PrDmggEUOEUTnzqDGGKgWAVx';
			$info=file_get_contents($url);
			$info=simplexml_load_string($info);
			printf($tpl,F,T,time(),$info->description);
			//echo '<meta charset=utf-8>'.$info->description;
		}elseif($msgType=='event'&&$msgEvent=='CLICK'){

			$api='http://zshop01.duapp.com/index.php/Home/Index/wechatApi';
			$key=$msg->EventKey;
			if($key=='goods_new'){
				$url=$api.'/type/new';
			}elseif($key=='goods_reco'){
				$url=$api.'/type/reco';
			}elseif($key=='goods_hot'){
				$url=$api.'/type/hot';
			}
			$data=json_decode(file_get_contents($url),true);
			$count=count($data);
			$pic_path='http://zshop01.duapp.com/Public/Uploads/';
			$str='';
			foreach($data as $v){
				$title=$v['goods_name'];
				$desc=$v['goods_sn'];
				$pic=$pic_path.$v['goods_img_path'];
				$url='http://zshop01.duapp.com/index.php/Goods/goodsShow/goods_id/'.$v['goods_id'];
				$str.=<<<STR
						<item>
							<Title><![CDATA[$title]]></Title> 
							<Description><![CDATA[$desc]]></Description>
							<PicUrl><![CDATA[$pic]]></PicUrl>
							<Url><![CDATA[$url]]></Url>
						</item>
STR;
			}
			printf($ntpl,F,T,time(),$count,$str);
		}
	} 


}

/*$token='vaBYrThQ5P0ZL6QUXZ8PYg22oBM1mq0MzaZRuTnbJIoQc247F31A5iLOLa_xxNgz0K2lTmtjbHCNKiWeTaOMhRxM0t6V8I8wLAB26hgRwHAWBVeAAALQK';
$url='https://api.weixin.qq.com/cgi-bin/menu/get?access_token='.$token;
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
//curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
$info=curl_exec($ch);
echo '<pre><meta charset=utf-8>';
print_r(json_decode($info,true));

$url='http://zshop01.duapp.com/index.php/Home/Index/wechatApi';
print_r(json_decode(file_get_contents($url),true));*/


//按钮创建
/****************************

$token='UuGeRh0T4z2M_JCm7b8Xd3dmSF9CxpZ9oAjlFQmIt22r_IYjKQIx8UGNPVdW4x5Hv4w6-5aPJ4fZ5LcZi0YkNZU53DpsrVhBgET2Lr1B8KsSCGbAFAMWA';

	$data=array(
		'button'=>array(
			array(
			'name'=>urlencode('商品展示'),
			'sub_button'=>array(
				array(
					'type'=>'click',
					'name'=>urlencode('热销商品'),
					'key'=>'goods_hot',
				),
				array(
					'type'=>'click',
					'name'=>urlencode('推荐商品'),
					'key'=>'goods_reco',
				),
				array(
					'type'=>'click',
					'name'=>urlencode('最新商品'),
					'key'=>'goods_new',
				),
			),
			),
			array(
			'type'=>'view',
			'name'=>urlencode('官方网址'),
			'url'=>'http://zshop01.duapp.com',
			),
			array(
			 'name'=>urlencode('了解我们'),
			 'sub_button'=>array(
				array(
				'type'=>'view',
				'name'=>urlencode('百度一下'),
				'url'=>'http://www.baidu.com',
				),
				array(
				"type"=>"scancode_waitmsg", 
                "name"=> urlencode("扫码"), 
                "key"=> "rselfmenu_0_0", 
                
				),
				array(
				"type"=>"view", 
                "name"=> urlencode("话不多说，注册一个"), 
                "url"=> "http://zshop01.duapp.com/index.php/Member/register", 
                
				),
			 ),
			),
		),
	);
	$data=urldecode(json_encode($data));
	$url='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$token;
	$ch=curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_POST,1);
	curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
	$res=curl_exec($ch);
	if($res===false){
		echo 'curl_error:'.curl_error($ch)."\n";
	}else{
		echo 'curl ok'."\n";
		curl_close($ch);
	}
	$res=json_decode($res);
	//print_r($res);
	if($res->errcode==0){
		echo 'meun ok';
	}else{
		echo $res->errcode.':'.$res->errmsg;
	}


***************************/
?>