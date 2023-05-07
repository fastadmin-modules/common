<?php

namespace app\common\model\common;


use think\Model;

/**
 * 编号生成记录
 */
class NumberGenerateRecord extends Model
{
    protected $name = 'number_generate_record';

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = false;

    const  NUMBER_TYPE_ORDER          	= 'order'; // 订单
    const  NUMBER_TYPE_REFUND         	= 'refund'; // 退款
    const  NUMBER_TYPE_WALLET_FLOW    	= 'wallet_flow'; // 钱包流水号
    const  NUMBER_TYPE_WITHDRAW_APPLY 	= 'withdraw_apply'; // 提现申请
    const  NUMBER_TYPE_WITHDRAW       	= 'withdraw'; // 提现
	const  PROMOTION_GAME_PRICE_WINNER 	= 'promotion_game_prize_winner'; //中奖记录
	const  PLATFORM_GOODS_CODE 			= 'platform_goods_code';  //商品二维码
	const  PLATFORM_INTEGRAL_SERIAL		= 'platform_integral_serial';  //积分流水
    const  PLATFORM_BATCH_CODE		    = 'platform_batch_code';  //瓶瓶批次码
    const  NUMBER_TYPE_CASH_PRIZE		= 'cash_prize';  //兑奖
}
