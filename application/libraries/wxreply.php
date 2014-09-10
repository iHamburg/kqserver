<?php
class Wxreply{
  public $textTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            <FuncFlag>0</FuncFlag>
            </xml>";   

  public $fromUsername;
  public $toUsername;
  

  public function replyText($text){

	   $resultStr = sprintf($this->textTpl, $this->fromUsername, $this->toUsername, time(), 'text', $text);
	   echo $resultStr;
  }


  
  public function replyNews($array){
	  $numOfArray = count($array);
	  
	  $resultStr="<xml>\n
				<ToUserName><![CDATA[".$this->fromUsername."]]></ToUserName>\n
				<FromUserName><![CDATA[".$this->toUsername."]]></FromUserName>\n
				<CreateTime>".time()."</CreateTime>\n
				<MsgType><![CDATA[news]]></MsgType>\n
				<ArticleCount>".$numOfArray."</ArticleCount>\n
				<Articles>\n";                  
			
	//数组循环转化
	foreach($array as $value)
	{
	  $resultStr.="<item>\n
	  <Title><![CDATA[".$value[0]."]]></Title> \n
	  <Description><![CDATA[]]></Description>\n
	  <PicUrl><![CDATA[".$value[1]."]]></PicUrl>\n
	  <Url><![CDATA[".$value[2]."]]></Url>\n
	  </item>\n";
	}
	
	$resultStr.="</Articles>\n
	<FuncFlag>0</FuncFlag>\n
	</xml>";
	
	echo $resultStr;
  }
  
  
  
  public  function testReply(){
  		$resultStr = sprintf($this->textTpl, 'from', 'to', time(), 'text', 'text');
	   echo $resultStr;
  }
}

