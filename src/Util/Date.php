<?php declare(strict_types=1);

namespace CouponPlugin\Util;

class Date
{
    /**
     * @return int
     */
    public static function get_now_time_stamp()
    {
        return Date::get_next_time_stamp();
    }

    /**
     * @return bool|string
     */
    public static function get_now_time()
    {
        return Date::get_next_time();
    }

    /**
     * @param int $second 秒
     * @return bool|string
     */
    public static function get_next_time($second = 0)
    {
        $time = Date::get_now_time_stamp() + $second;

        return date('Y-m-d H:i:s', $time);
    }

    /**
     * @param int $second
     * @return int
     */
    public static function get_next_time_stamp($second = 0)
    {
        $time = time() + $second;

        return $time;
    }
}
