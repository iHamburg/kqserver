<?php


function randomCharacter($number){
		$m = '0123456789abcdefghijkpqrstuvwxyzABCDEFGHIJKPQRSTUVWXYZ';
		$s = str_shuffle($m);
		$str = substr($s,1,$number);
		return $str;
}


/**
 * 
 * update 如果最后一个字符是1，删除1
 * @param unknown_type $json
 */
function patchUpdateLast1($json){
//				
	if(strcmp(substr($json, -1),'1') == 0){

		$json = substr($json,0,strlen($json)-1);
	
	}

	return $json;
}
	
/**
 * 把utf-8的中文乱码复原
 * @param string $str
 */
	function decodeUnicode($str)
	{
   		 return preg_replace_callback('/\\\\u([0-9a-f]{4})/i',
        create_function(
            '$matches',
            'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'
        ),
        $str);
	}

function display_helper(){
	return 'display helper';
	
	
}

function array_slice_keys($array,$keys){
	
	if(empty($array))
		return NULL;
	
	foreach ($keys as $key) {
		$arr[$key] = $array[$key];
	}
	
	return $arr;
}

function echobr($str=''){
	echo $str;
	echo '<br/>';
}


function exportFile($fileName, $contents){
	
//	header("Content-type: text/html; charset=utf-8");
	
		$fp = fopen($fileName, 'w');

		foreach ($contents as $fields) {
			
			
		    fputcsv($fp, $fields);

		}

		fclose($fp);
}

function exportFile2($fileName, $contents){
	
//	header("Content-type: text/html; charset=utf-8");
	
		$fp = fopen($fileName, 'w');

		foreach ($contents as $fields) {
			$array = array();
			foreach ($fields as $field) {
				$array[] = iconv( "UTF-8","gbk",$field);
			}
			
		    fputcsv($fp, $array);

		}

		fclose($fp);
}

function fgetcsv_reg(& $handle, $length = null, $d = ',', $e = '"') {
        $d = preg_quote($d);
        $e = preg_quote($e);
        $_line = "";
        $eof=false;
        while ($eof != true) {
                $_line .= (empty ($length) ? fgets($handle) : fgets($handle, $length));
                $itemcnt = preg_match_all('/' . $e . '/', $_line, $dummy);
                if ($itemcnt % 2 == 0)
                        $eof = true;
        }
        $_csv_line = preg_replace('/(?: |[ ])?$/', $d, trim($_line));
        $_csv_pattern = '/(' . $e . '[^' . $e . ']*(?:' . $e . $e . '[^' . $e . ']*)*' . $e . '|[^' . $d . ']*)' . $d . '/';
        preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
        $_csv_data = $_csv_matches[1];
        for ($_csv_i = 0; $_csv_i < count($_csv_data); $_csv_i++) {
                $_csv_data[$_csv_i] = preg_replace('/^' . $e . '(.*)' . $e . '$/s', '$1', $_csv_data[$_csv_i]);
                $_csv_data[$_csv_i] = str_replace($e . $e, $e, $_csv_data[$_csv_i]);
        }
        return empty ($_line) ? false : $_csv_data;
}

function imgUrlOfThumb($thumbnail){
	///images/dummy-thumb.jpg 
//	$imgsrc2 = base_url("public/images/cat.jpg");
	
	$imgsrc = 'public'.$thumbnail;
	return base_url($imgsrc);
}

function newline(){
	echo '<br/>';
}

/**
 * 
 * Enter description here ...
 * @param string $url
 * @param array $post_data
 */
function curl($url,$post_data){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// 我们在POST数据哦！
		curl_setopt($ch, CURLOPT_POST, 1);
		// 把post的变量加上
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
		$output = curl_exec($ch);
		curl_close($ch);
		
		return $output;
}

function date_with_datetime($datetime){
		$timestamp =  strtotime($datetime);
		$date = date("Y-m-d",$timestamp);
		return $date;
}

/**
 * 
 * 返回datetime的time
 * @param unknown_type $datetime
 */
function time_with_datetime($datetime){
	date_default_timezone_set("PRC");
		$timestamp =  strtotime($datetime);
		$time = date("H:i",$timestamp);
		return $time;
}


function transTime($ustime) {            

	date_default_timezone_set("PRC");            

	$ytime=date("Y-m-d H:i",$ustime);

	$rtime=date("n月j日",$ustime);
	
	$htime=date("H:i",$ustime);         

	$time=time()-$ustime;          

	$todaytime=strtotime("today");
	$time1=time()-$todaytime;
	 

	if($time>=0){
		if($time<=60){
			$str='刚刚';
		}
		else if($time<=60*60){
			$str= floor($time/60).'分钟前';
		}
		else if($time<=60*60*24){
			$str =  floor($time/3600).'小时前';    
		}
		else{
			$str = $rtime;    
		}
	}
	else{
		$str = $rtime;    
	}
	
	return $str;
	
}

function traceHttp(){
        logger("\n\nREMOTE_ADDR:".$_SERVER["REMOTE_ADDR"].(strstr($_SERVER["REMOTE_ADDR"],'101.226')? " FROM WeiXin": "Unknown IP"));
        logger("QUERY_STRING:".$_SERVER["QUERY_STRING"]);
        $poststr=file_get_contents("php://input");
        logger("_content:".var_export($poststr,true));
        logger("_content2:".var_export($_GET,true));
        logger("GLOBALS:".$GLOBALS["HTTP_RAW_POST_DATA"]);
}

/////////////////
function tracehttp2(){
        logger("\n\nREMOTE_ADDR:".$_SERVER["REMOTE_ADDR"].(strstr($_SERVER["REMOTE_ADDR"],'101.226')? " FROM WeiXin": "Unknown IP"));
        logger("QUERY_STRING:".$_SERVER["QUERY_STRING"]);
        $poststr=file_get_contents("php://input");
        logger("_content:".var_export($poststr,true));
        logger("_content2:".var_export($_GET,true));
        logger("GLOBALS:".$GLOBALS["HTTP_RAW_POST_DATA"]);
}

function logger($content){
        file_put_contents("log.html",date('Y-m-d H:i:s').$content."\n",FILE_APPEND);
}


/**
 * 
 * 如果admin没有登录，自动转到admin登录页面
 */
function check_admin_session(){
		
//	return true;
	
	$CI = & get_instance();
	
	$session_key=$CI->config->item('admin_session_key');

	if(!isset($_SESSION[$session_key])){
	
		redirect('admin/dashboard/login','refresh');
		
	}
}


function show_custom_error($message, $status_code = 500, $heading = 'An Error Was Encountered'){

	$_error =& load_class('Exceptions', 'core');
	echo $_error->show_error($heading, $message, 'error_general', $status_code);
		
}


function get($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	//curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);

	$output = curl_exec($ch);
	curl_close($ch);

	return $output;
}

function post($url='',$data=''){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);

	//curl_setopt($ch, CURLOPT_HTTPHEADER, $this->jsonHeader);

	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$output = curl_exec($ch);
	curl_close($ch);

	return $output;
}
