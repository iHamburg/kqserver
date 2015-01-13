<?php


class News2_m extends MY_Model{
	
	
	public $_table = 'news';
	protected $return_type = 'array';
	
	
	public function __construct(){
		parent::__construct();
	
	}
	
	// uid, title, text
	public function insert_news($title,$text,$uid=0){
		return $this->db->query("insert into news (uid,title,text) values($uid,'$title','$text')");
	}

	//您已成功下载xxx(摩提工房满30立减5元)快券，前往最近的门店使用任意一张绑定的银联卡刷卡消费即可享受快券的优惠咯！
	// 您已成功下载摩提工房满30立减5元快券，这是您第一次下载快券，添加任意一张银联卡就可以开始享受快券的优惠咯！
	public function insert_download_coupon_news($uid,$couponTitle){
		
	}
	
	public function sendTestNews(){
	
		$query = $this->db->query("select * from news limit 10");
		
		return $query->result_array();
		
	}
	
}