<?php
class Morders extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	function updateCart($productid, $fullproduct){
	
		$cart = $_SESSION['cart'];
		$totalprice = 0;
		if (count($fullproduct)){
			if (isset($cart[$productid])){
				//如果已经有这个product了
				$prevct = $cart[$productid]['count'];
				$prevname = $cart[$productid]['name'];
				$prevprice = $cart[$productid]['price'];
				
				$cart[$productid] = array(
					'name' => $prevname,
					'price' => $prevprice,
					'count' => $prevct + 1
				);
			
			}
			else{
				// 如果cart中还没有这个product
				$cart[$productid] = array(
					'name' => $fullproduct['name'],
					'price' => $fullproduct['price'],
					'count' => 1
				);
			}
		}
		
		#计算总价
		foreach ($cart as $id=>$product){
			$totalprice += $product['price']*$product['count'];
		}
		
		$_SESSION['totalprice'] = $totalprice;
		$_SESSION['cart'] = $cart;
		
		$this->session->set_flashdata('conf_msg',"we have added price to cart");
	}
}