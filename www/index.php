<?php
define("TOKEN", "shane");
logger();
$wechatObj = new wechatCallbackapiTest();
$wechatObj->valid();
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
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;


                $keyword = trim($postObj->Content);
		file_put_contents("log.html",$keyword."#FROMUSER#".date('Y-m-d H:i:s ').$fromUsername."<br />",FILE_APPEND);
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";            
$newsTpl = 
"
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<ArticleCount>1</ArticleCount>
<Articles>
<item>
<Title><![CDATA[%s]]></Title>
<Description><![CDATA[%s]]></Description>
<PicUrl><![CDATA[%s]]></PicUrl>
<Url><![CDATA[%s]]></Url>
</item>
</Articles>
<FuncFlag>1</FuncFlag>
</xml>
";

$news_header =
"
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<ArticleCount>%d</ArticleCount>
<Articles>
";
$news_item =
"
<item>
<Title><![CDATA[%s]]></Title>
<Description><![CDATA[%s]]></Description>
<PicUrl><![CDATA[%s]]></PicUrl>
<Url><![CDATA[%s]]></Url>
</item>
";
$news_footer =
"
</Articles>
<FuncFlag>1</FuncFlag>
</xml>
";

if($postObj->Content=="热门活动")
{
			$msgType = "news";
			$contentStr = file_get_contents("https://api.douban.com/v2/event/list?loc=118371&day_type=tomorrow&type=all");
			$events_json = json_decode($contentStr);
			$resultStr = sprintf($news_header, $fromUsername, $toUsername, $time, $msgType, 10);
			for($i = 0;$i<10;$i++)
{
$resultStr .= sprintf($news_item, $events_json->events[$i]->title,$events_json->events[$i]->wisher_count."对此活动很感兴趣",$events_json->events[$i]->image_lmobile,$events_json->events[$i]->adapt_url);
}
			$resultStr .= $news_footer;
			echo $resultStr;
die;
}

 
		if(!empty( $keyword ))
                {
              		$msgType = "news";
			$contentStr = file_get_contents("https://api.douban.com/v2/event/list?loc=118371&day_type=tomorrow&type=all&start=0&count=100");

			$test = json_decode($contentStr);

//	file_put_contents("log.html",date('Y-m-d H:i:s ')."Content".$test->events[$keyword]->title."<br />",FILE_APPEND);
                	$resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType,$test->events[$keyword-1]->title,$test->events[$keyword-1]->wisher_count."对此活动很感兴趣",$test->events[$keyword-1]->image_lmobile,$test->events[$keyword-1]->adapt_url);
                	echo $resultStr;
                }
		else
		{
			$msgType = "news";
			$resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time,$msgType,"欢迎关注“young长安”公共主页。","输入“热门活动”可以查看这段时间内最热的活动；输入1-100内的数字，可以详细查看自己喜欢的活动。","http://nanyang.xjtu.edu.cn/WeChat/ico.jpg","http://nanyang.xjtu.edu.cn/WeChat/note.html" );
			echo $resultStr;
                }

        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

function logger()
{
	file_put_contents("log.html",date('Y-m-d H:i:s ')."REMOTE_ADDR".$_SERVER["REMOTE_ADDR"]."<br />",FILE_APPEND);
}

?> 
