<?php


define("ErrorEmptyParameter",   400);
define("ErrorEmptyUsernamePwd", 401);
define("ErrorEmptyUid", 		  403);
define("ErrorEmptyCard",	      404);
define("ErrorEmptyCouponId",    405);
define("ErrorEmptySession",     406);
define("ErrorEmptyShopId",      407);
define("ErrorEmptyUnionCouponId",      408);
define("ErrorEmptyUnionUid", 409);

define("ErrorInvalidUsernamePwd", 601);
define("ErrorInvalidUsername",  602);
define("ErrorInvalidCouponId",  603);
define("ErrorInvalidSession",   604);
define("ErrorInvalidPassword",   605);

define("ErrorDBUpdate", 701);
define("ErrorDBDelete", 702);
define("ErrorDBInsert", 703);

define("ErrorFailureSMS",    801);
define("ErrorLimitDCoupon",  802);
define("ErrorFailureDCoupon", 803);


define("ErrorUsernameExists",   1001);
define("ErrorCardExists",   1003);

define("ErrorUnionInvalidCard", 300500);
define("ErrorUnionExistCard", 300519);
define("ErrorUnionLimitCardNumber", 300520);
define("ErrorUnionUnknown", 300000);
define("ErrorUnionInvalidCoupon", 500046);
define("ErrorUnionInvalidParameter", 300002);
define("ErrorUnionEmptyUser", 300200);  // 查询结果
define("ErrorUnionNoCardBunden", 500058);
define("ErrorUnionBindCardToOften", 300521);
define("ErrorUnionDCouponLimt", 500048);  


//define("ErrorUnionGetUser", 900);
//define("ErrorUnionRegister", 901);
//define("ErrorUnionBindCard", 902);
//define("ErrorUnionUnbindCard", 903);
//define("ErrorUnionDownloadCoupon", 904);




function msg_with_error($error){
	
	switch ($error) {
		case ErrorEmptyParameter:
		  $msg = '传入的参数不完整';
		break;
		case ErrorEmptyUsernamePwd:
		  $msg = '用户名或密码为空';
		break;
		case ErrorEmptyUid:
		  $msg = '用户ID为空';
		break;
		case ErrorEmptyCard:
		  $msg = '卡号为空';
		break;
		case ErrorEmptyCouponId:
		  $msg = '快券Id为空';
		break;
		case ErrorEmptySession:
		  $msg = 'Session为空';
		break;
		case ErrorEmptyShopId:
		  $msg = 'ShopId为空';
		break;
		case ErrorEmptyUnionCouponId:
		  $msg = '优惠券的银联编号为空';
		break;
		case ErrorEmptyUnionUid:
		  $msg = '用户的银联编号为空';
		break;
		
		case ErrorInvalidUsernamePwd:
		  $msg = '用户名或密码错误';
		break;
		case ErrorInvalidSession:
		  $msg = '无效的Session';
		break;
		case ErrorInvalidUsername:
		  $msg = '无效的用户名';
		break;
		case ErrorInvalidCouponId:
		  $msg = '无效的快券';
		break;
		case ErrorInvalidPassword:
		  $msg = '密码错误';
		break;
	
		case ErrorFailureSMS:
		  $msg = '短信发送错误';
		break;
		case ErrorLimitDCoupon:
		  $msg = '用户不能下载该快券';
		break;
		case ErrorFailureDCoupon:
		  $msg = '用户下载快券失败';
		break;
		
		case ErrorDBUpdate:
		  $msg = '数据库更新错误';
		break;
		case ErrorDBDelete:
		  $msg = '数据库删除错误';
		break;
		case ErrorDBInsert:
		  $msg = '数据库插入错误';
		break;
		
		case ErrorUsernameExists:
		  $msg = '用户名已存在';
		break;
		case ErrorCardExists:
		  $msg = '用户已经绑定该银行卡';
		break;
		
		case ErrorUnionInvalidCard:
		  $msg = '卡号无效';
		break;
		case ErrorUnionExistCard:
		  $msg = '重复绑卡';
		break;
		case ErrorUnionLimitCardNumber:
		  $msg = '超过最大开通钱包服务的卡的数量';
		break;
		case ErrorUnionNoCardBunden:
			$msg = '没有绑卡的用户不能下载';
		break;
		case ErrorUnionUnknown:
		  $msg = '未知银联错误';
		break;
//		case ErrorUnionGetUser:
//			$msg = '银联查询用户错误';
//		break;
//		case ErrorUnionRegister:
//			$msg = '银联注册用户错误';
//		break;
//		case ErrorUnionBindCard:
//			$msg = '银联绑卡错误';
//		break;
//		case ErrorUnionUnbindCard:
//			$msg = '银联解卡错误';
//		break;
//		case ErrorUnionDownloadCoupon:
//			$msg = '银联下载快券错误';
//		break;
		case ErrorUnionEmptyUID:
			$msg = '没有银联用户id';
		break;
		case ErrorUnionInvalidCoupon:
			$msg = '银联优惠券无效';
		break;
		case ErrorUnionInvalidParameter:
			$msg = '银联参数值无效';
		break;
		case ErrorUnionEmptyUser:
			$msg = '银联用户不存在';
		break;
		case ErrorUnionBindCardToOften:
			$msg = '银联解绑卡过于频繁';
		break;
		case ErrorUnionDCouponLimt:
			$msg = '银联优惠券下载张数超过单用户下载限制';
		break;
		default:
		 $msg = '服务器未知错误';
		break;
	}
	
	return $msg;
	
}