<?php declare(strict_types=1);

namespace CouponPlugin\Util;

use CouponPlugin\ErrorException;
use DateTime;

/**
 * Class Date
 * @package CouponPlugin\Util
 */
class Date
{
    const DATE_FORMAT = 'Y-m-d H:i:s';

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

        return date(self::DATE_FORMAT, $time);
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

    public static function before($time)
    {
        $date = DateTime::createFromFormat(self::DATE_FORMAT, $time);
        if (!$date) {
            throw new ErrorException('Invalid time format!');
        }

        return time() > $date->getTimestamp();
    }

    public static function after($time)
    {
        $date = DateTime::createFromFormat(self::DATE_FORMAT, $time);
        if (!$date) {
            throw new ErrorException('Invalid time format!');
        }

        return time() < $date->getTimestamp();
    }
}
