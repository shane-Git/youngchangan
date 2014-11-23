<?php
define("TOKEN", "812223035");

$textTpl = 
"<xml>
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
	global $textTpl,$newsTpl,$news_header,$news_item,$news_footer;
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;

switch($postObj->MsgType)
{
  case "text":
  {
  $time = time();
  $keyword = trim($postObj->Content);
  $msgType ; $contentStr ; $events_json ; $resultStr;
  $msgType = "news";
  
  switch($postObj->Content)
  {
    case "大学活动":
    {
      $msgType = "news";
      $contentStr = file_get_contents("http://nanyang.xjtu.edu.cn:8080/young/");
      $contentStr = str_replace("&quot;",'"',$contentStr);
      $events_json = json_decode($contentStr);
      $resultStr = sprintf($news_header, $fromUsername, $toUsername, $time, $msgType,$events_json->total);
      for($i = 0;$i<$events_json->total;$i++)
      {
        $resultStr .= sprintf($news_item, $events_json->events[$i]->title,"对此>活动很感兴趣",$events_json->events[$i]->image_lmobile,$events_json->events[$i]->adapt_url);
      }
      $resultStr .= $news_footer;
      echo $resultStr;
      die;
    break;
    }
    case "热门活动":
    {
      file_get_contents("http://nanyang.xjtu.edu.cn:8080/young/Session/".md5($fromUsername)."/".base64_encode("https://api.douban.com/v2/event/list?loc=118371&day_type=tomorrow&type=all&count=5")."/");
    break;
    }
    case "音乐":
    {
      file_get_contents("http://nanyang.xjtu.edu.cn:8080/young/Session/".md5($fromUsername)."/".base64_encode("https://api.douban.com/v2/event/list?loc=118371&day_type=tomorrow&type=music&count=5")."/");
    break;
    }
    case "戏剧":
    {
      file_get_contents("http://nanyang.xjtu.edu.cn:8080/young/Session/".md5($fromUsername)."/".base64_encode("https://api.douban.com/v2/event/list?loc=118371&day_type=tomorrow&type=drama&count=5")."/");
    break;
    }
    case "展览":
    {
      file_get_contents("http://nanyang.xjtu.edu.cn:8080/young/Session/".md5($fromUsername)."/".base64_encode("https://api.douban.com/v2/event/list?loc=118371&day_type=tomorrow&type=exhibition&count=5")."/");
    break;
    }
    case "讲座":
    {
      file_get_contents("http://nanyang.xjtu.edu.cn:8080/young/Session/".md5($fromUsername)."/".base64_encode("https://api.douban.com/v2/event/list?loc=118371&day_type=tomorrow&type=salon&count=5")."/");

    break;
    }
    case "聚会":
    {
      file_get_contents("http://nanyang.xjtu.edu.cn:8080/young/Session/".md5($fromUsername)."/".base64_encode("https://api.douban.com/v2/event/list?loc=118371&day_type=tomorrow&type=party&count=5")."/");
    break;
    }
    case "下一页":
    {
      $session_json = file_get_contents("http://nanyang.xjtu.edu.cn:8080/young/Session/".md5($fromUsername)."/a/");
    break;
    }
    case "上一页":
    {
      $session_json = file_get_contents("http://nanyang.xjtu.edu.cn:8080/young/Session/".md5($fromUsername)."/s/");
    break;
    }
    case "运动":
    {
      file_get_contents("http://nanyang.xjtu.edu.cn:8080/young/Session/".md5($fromUsername)."/".base64_encode("https://api.douban.com/v2/event/list?loc=118371&day_type=tomorrow&type=sports&count=5")."/");
    break;
    }
    case "旅行":
    {
      file_get_contents("http://nanyang.xjtu.edu.cn:8080/young/Session/".md5($fromUsername)."/".base64_encode("https://api.douban.com/v2/event/list?loc=118371&day_type=tomorrow&type=travel&count=5")."/");
    break;
    }
    case "公益":
    {
      file_get_contents("http://nanyang.xjtu.edu.cn:8080/young/Session/".md5($fromUsername)."/".base64_encode("https://api.douban.com/v2/event/list?loc=118371&day_type=tomorrow&type=commonweal&count=5")."/");
    break;
    }
    case "电影":
    {
      file_get_contents("http://nanyang.xjtu.edu.cn:8080/young/Session/".md5($fromUsername)."/".base64_encode("https://api.douban.com/v2/event/list?loc=118371&day_type=tomorrow&type=film&count=5")."/");
    break;
    }
    case "帮助":
    {
      $msgType = "news";
      $resultStr = sprintf($news_header, $fromUsername, $toUsername, $time, $msgType, 4);
      $resultStr .= sprintf($news_item, "欢迎关注“young长安”公共主页","","http://nanyang.xjtu.edu.cn/WeChat/banner.jpg" ,"http://nanyang.xjtu.edu.cn/WeChat/note.html");
      $resultStr .= sprintf($news_item, "输入“热门活动”可以查看这段时间内最热门的活动；","","http://nanyang.xjtu.edu.cn/WeChat/ico/star.jpg" ,"http://nanyang.xjtu.edu.cn/WeChat/note.html");
      $resultStr .= sprintf($news_item, "支持分类别查看活动，可以输入“音乐”，“电影”，“运动”，“聚会”等；","","http://nanyang.xjtu.edu.cn/WeChat/ico/cat.jpg" ,"http://nanyang.xjtu.edu.cn/WeChat/note.html");
      $resultStr .= sprintf($news_item, "如有疑问请点此查看更多>>","","http://nanyang.xjtu.edu.cn/WeChat/ico/more.jpg" ,"http://nanyang.xjtu.edu.cn/WeChat/note.html");
      $resultStr .= $news_footer;
      echo $resultStr;
      die;
    break;
    }
    case "个人":
    {
      $msgType = "news";
      $resultStr = sprintf($news_header, $fromUsername, $toUsername, $time, $msgType, 5);
      $resultStr .= sprintf($news_item, "个人功能菜单","","http://nanyang.xjtu.edu.cn/WeChat/per.jpg" ,"http://nanyang.xjtu.edu.cn/WeChat/note.html");
      $resultStr .= sprintf($news_item, "我的足迹","","http://nanyang.xjtu.edu.cn/WeChat/ico/arrow.png" ,"http://nanyang.xjtu.edu.cn:8080/young/MyGPS/".md5($fromUsername)."/");
      $resultStr .= sprintf($news_item, "我的随拍","","http://nanyang.xjtu.edu.cn/WeChat/ico/photo.png" ,"http://nanyang.xjtu.edu.cn:8080/young/MyPic/".md5($fromUsername)."/");
      $resultStr .= sprintf($news_item, "注册活动","","http://nanyang.xjtu.edu.cn/WeChat/ico/flag.png" ,"http://nanyang.xjtu.edu.cn:8080/young/RegEvent/".md5($fromUsername)."/");
      $resultStr .= sprintf($news_item, "如有疑问请点此查看更多>>","","http://nanyang.xjtu.edu.cn/WeChat/ico/more.jpg" ,"http://nanyang.xjtu.edu.cn/WeChat/note.html");
      $resultStr .= $news_footer;
      echo $resultStr;
      die;
    break;
    }
    case "手气不错":
    {
      $msgType = "news";
      $keepStr = $postObj->Content;
      $contentStr = file_get_contents("https://api.douban.com/v2/event/list?loc=118371&day_type=tomorrow&type=all&start=0&count=100");
      $test = json_decode($contentStr);
      $base = $test->total;
      if($test->total > 100)
      {
        $base = 100;
      }
      $randNum = rand()%$base;
      $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType,$test->events[$randNum]->title,$test->events[$randNum]->wisher_count."对此活动很感兴趣",$test->events[$randNum]->image_lmobile,$test->events[$randNum]->adapt_url);
      echo $resultStr;
      die;
    break;
    }
    default:
    {
      if($postObj->Content)
      {
        $msgType = "news";
        $keepStr = $postObj->Content;
        if( (int)$keepStr > 0 && (int)$keepStr <= 4)
        {
          $MySession = file_get_contents("http://nanyang.xjtu.edu.cn:8080/young/Session/".md5($fromUsername)."/g/");
          $MySession = str_replace("&quot;",'"',$MySession);
          $MySession = json_decode($MySession);
          $contentStr = file_get_contents($MySession->Category."&start=".$MySession->Page*4);
          $test = json_decode($contentStr);
          $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType,$test->events[$keyword-1]->title,$test->events[$keyword-1]->wisher_count."对此活动很感兴趣",$test->events[$keyword-1]->image_lmobile,$test->events[$keyword-1]->adapt_url);
        }
        else
        {
          $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time,$msgType,"输入无效 真的桑感情。。","请查看具体的帮助信息>>","http://nanyang.xjtu.edu.cn/WeChat/ico/error.jpg","http://nanyang.xjtu.edu.cn/WeChat/note.html");
        }
        echo $resultStr;
        die;
      }
    }
  }
      $MySession = file_get_contents("http://nanyang.xjtu.edu.cn:8080/young/Session/".md5($fromUsername)."/g/");
      $MySession = str_replace("&quot;",'"',$MySession);
      $MySession = json_decode($MySession);
      $contentStr = file_get_contents($MySession->Category."&start=".$MySession->Page*4);
      $events_json = json_decode($contentStr);
      $count = $events_json->total-$MySession->Page*4;
      if($count <=0 || $MySession->Page <0)
      {
        $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time,$msgType,"页码范围有误","请重新输入类别","http://nanyang.xjtu.edu.cn/WeChat/ico/error.jpg","");
        echo $resultStr;
        die;
      }
      if($count >4)
      {
        $count = 4;
      }
      $resultStr = sprintf($news_header, $fromUsername, $toUsername, $time, $msgType,$count+1);
      for($i = 0;$i<$count;$i++)
      {
        $resultStr .= sprintf($news_item,"[".($i+1)."]". $events_json->events[$i]->title,"对此活动很感兴趣",$events_json->events[$i]->image_lmobile,$events_json->events[$i]->adapt_url);
      }
      $resultStr .= sprintf($news_item,"共".$events_json->total."个活动，目前在".($MySession->Page+1)."/".(ceil($events_json->total/4))."页。\n输入“上一页”或者“下一页”以翻页，输入事件前序号可以选择单条时间以分享～","","","");
      $resultStr .= $news_footer;
      echo $resultStr;
     die;

  break;
  }
  case "location":
  {
    file_put_contents("log.html",$keyword."#FROMUSER#".date('Y-m-d H:i:s ').$fromUsername.$postObj->Location_X."|".$postObj->Location_Y."<br />",FILE_APPEND);
    $str = file_get_contents("http://nanyang.xjtu.edu.cn:8080/young/GPS/".$postObj->Location_X.'/'.$postObj->Location_Y.'/'.md5($fromUsername).'/');
    $resultStr = sprintf($textTpl, $fromUsername, $toUsername,time(), "text", "Already Got You GPS.$str");
    echo $resultStr;
    die;
  break;
  }
  case "image":
  {
    file_put_contents("log.html",$keyword."#FROMUSER#".date('Y-m-d H:i:s ').$fromUsername.$postObj->PicUrl."<br />",FILE_APPEND);
    file_get_contents("http://nanyang.xjtu.edu.cn:8080/young/Image/".base64_encode($postObj->PicUrl).'/'.md5($fromUsername).'/');
    $resultStr = sprintf($textTpl, $fromUsername, $toUsername,time(), "text", "Already Got You Image.$str");
    echo $resultStr;
    die;
  break;
  }
}

if(!$postObj->Content)
{ 
  $msgType = "news";
  $resultStr = sprintf($news_header, $fromUsername, $toUsername, $time, $msgType, 4);
  $resultStr .= sprintf($news_item, "欢迎关注“young长安”公共主页","对此活动很感兴趣","http://nanyang.xjtu.edu.cn/WeChat/banner.jpg" ,"http://nanyang.xjtu.edu.cn/WeChat/note.html");
  $resultStr .= sprintf($news_item, "输入“热门活动”可以查看这段时间内最热门的活动；","对此活动很感兴趣","http://nanyang.xjtu.edu.cn/WeChat/ico/star.jpg" ,"http://nanyang.xjtu.edu.cn/WeChat/note.html");
  $resultStr .= sprintf($news_item, "支持分类别查看活动，可以输入“音乐”，“电影”，“运动”，“聚会”等；","对此活动很感兴趣","http://nanyang.xjtu.edu.cn/WeChat/ico/cat.jpg" ,"http://nanyang.xjtu.edu.cn/WeChat/note.html");
  $resultStr .= sprintf($news_item, "如有疑问请点此查看更多>>","对此活动很感兴趣","http://nanyang.xjtu.edu.cn/WeChat/ico/more.jpg" ,"http://nanyang.xjtu.edu.cn/WeChat/note.html");
  $resultStr .= $news_footer;
  echo $resultStr;
  die;
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
