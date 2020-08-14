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

    /**
     * 获取当前日期是第几周以及该周的开始日期和结束日期
     *
     * @param string $date 日期
     * @param integer $first 设定一周的开始时间，默认为1，即周一，0则代表周日为开始时间
     * @return array
     */
    public static function getNowTimeInfo($date, $first = 1)
    {
        $result = [];
        // 获取年份
        $result['year'] = date('Y', strtotime($date));
        // 获取当前日期在整年中的第几周
        $result['week'] = date('W', strtotime($date));
        // 获取给定的日期是周几，0是周日，取值范围是0至6，分别代表周日至周六
        $week = date('w', strtotime($date));
        // 获取给定日期的周开始日期
        $weekBegin = date('Y-m-d', strtotime("$date -" . ($week ? $week - $first : 6) . ' days'));
        $result['week_begin'] = $weekBegin;
        // 获取给定日期的周结束日期
        $weekEnd = date('Y-m-d', strtotime("$weekBegin + 6 days"));
        $result['week_end'] = $weekEnd;
        return $result;
    }

    /**
     * 秒转换为天，小时，分钟
     *
     * @param integer $second 时间戳
     * @return void
     */
    function secondChanage($second = 0)
    {
        $newtime = '';
        $d = floor($second / (3600 * 24));
        $h = floor(($second % (3600 * 24)) / 3600);
        $m = floor((($second % (3600 * 24)) % 3600) / 60);
        $s = $second - ($d * 24 * 3600) - ($h * 3600) - ($m * 60);

        empty($d) ?  
        $newtime = (
                empty($h) ? (
                    empty($m) ? $s . '秒' : ( 
                        empty($s) ? $m.'分' :  $m.'分'.$s.'秒'
                        )
                    ) : (
                    empty($m) && empty($s) ? $h . '时' : (
                        empty($m) ? $h . '时' . $s . '秒' : (
                            empty($s) ? $h . '时' . $m . '分' : $h . '时' . $m . '分' . $s . '秒'
                            )
                    )
                )
        ) : $newtime = (
            empty($h) && empty($m) && empty($s) ? $d . '天' : (
                empty($h) && empty($m) ? $d . '天' . $s .'秒' : (
                    empty($h) && empty($s) ? $d . '天' . $m .'分' : (
                        empty($m) && empty($s) ? $d . '天' .$h . '时' : (
                            empty($h) ? $d . '天' .$m . '分' . $s .'秒' : (
                                empty($m) ? $d . '天' .$h . '时' . $s .'秒' : (
                                    empty($s) ? $d . '天' .$h . '时' . $m .'分' : $d . '天' .$h . '时' . $m .'分' . $s . '秒'
                                )
                            )
                        )
                    )
                )
            )
        );
    
        return $newtime;
    }
}
