<?php


define(ErrorEmptyParameter,   400);
define(ErrorEmptyUsernamePwd, 401);
define(ErrorEmptyUid, 		  403);
define(ErrorEmptyCard,	      404);
define(ErrorEmptyCouponId,    405);
define(ErrorEmptySession,     406);
define(ErrorEmptyShopId,      407);

define(ErrorInvalidUsernamePwd, 601);
define(ErrorInvalidUsername,  602);
define(ErrorInvalidCouponId,  603);
define(ErrorInvalidSession,   604);
define(ErrorInvalidPassword,   605);

define(ErrorFailureSMS,    801);


define(ErrorUsernameExists,   1001);
define(ErrorNotRegisterUnion,   1002);

define(ErrorUnionInvalidCard, 300500);
define(ErrorUnionExistCard, 300519);
define(ErrorUnionLimitCardNumber, 300520);
define(ErrorUnionUnknown, 300000);

function msg_with_error($error){
	
	switch ($error) {
		case ErrorEmptyParameter:
		  $msg = '传入的参数不完整';
		break;
		case ErrorEmptyUsernamePwd:
		  $msg = '用户名或密码为空';
		break;
		case ErrorEmptyUidCouponId:
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
		
		case ErrorUsernameExists:
		  $msg = '用户名已存在';
		break;
		case ErrorNotRegisterUnion:
		  $msg = '用户没有注册银联钱包';
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
		case ErrorUnionUnknown:
		  $msg = '未知银联错误';
		break;
		
		default:
		 $msg = '未知错误';
		break;
	}
	
	return $msg;
	
}