<?php

namespace Supen\Supports;

class Utils
{
    public static function makeNumber($prefix = null, $suffix = null)
    {
        return ($prefix ?? '') . date('YmdHis') . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT) . ($suffix ?? '');
    }

    public static function makeIdNumber($prefix = null, $id = 0)
    {
        return ($prefix ?? '') . date('YmdHis') . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT) . str_pad(intval($id), 8, '0', STR_PAD_LEFT);
    }

    public static function makeEncode($code = null, $prefix = null, $suffix = null)
    {
        return ($prefix ?? '') . strtoupper(base_convert($code ?? self::makeNumber(), 10, 36)) . ($suffix ?? '');
    }

    public static function makeDecode($code)
    {
        return base_convert($code, 36, 10);
    }

    public static function makeEnNumber($number = null)
    {
        $rand_left = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

        $number = $rand_left . ($number ?? time());

        return base_convert($number, 10, 36);
    }

    public static function makeDeNumber($code)
    {
        $number = base_convert($code, 36, 10);

        $number = substr($number, 5);

        return $number;
    }

    /**
     * 获取客户端IP
     * @return [type] [description]
     */
    public static function getClientIP()
    {
        //判断服务器是否允许$_SERVER
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
        } else {
            //不允许就使用getenv获取
            if (getenv("HTTP_X_FORWARDED_FOR")) {
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } elseif (getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
            } else {
                $realip = getenv("REMOTE_ADDR");
            }
        }

        return $realip;
    }

    /**
     * 判断是否手机号
     *
     * @param [type] $mobile
     * @return boolean
     */
    public static function is_mobile($mobile)
    {
        $pat = '/'
            . '^13\d{9}$'
            . '|^14[59]\d{8}$'
            . '|^15[^4]\d{8}$'
            . '|^16[2567]\d{8}$'
            . '|^17[0-8]\d{8}$'
            . '|^18\d{9}$'
            . '|^19[13589]\d{8}$'
            . '/';
        return preg_match($pat, $mobile) ? true : false;
    }

    /**
     * 判断微信还是支付宝扫码
     *
     * @return void
     */
    public function IsWeixinOrAlipay()
    {
        //获取用户信息
        //dump($_SERVER['HTTP_USER_AGENT']);
        //判断是不是微信
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return "Weixin";
        }
        //判断是不是支付宝
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'AlipayClient') !== false) {
            return "Alipay";
        }
    }
}
