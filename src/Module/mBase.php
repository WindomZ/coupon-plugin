<?php declare(strict_types=1);

namespace CouponPlugin\Module;

/**
 * Class mBase
 * @package CouponPlugin\Module
 */
abstract class mBase
{
    private function __construct()
    {
    }

    /**
     * @param mixed $obj
     * @return mixed
     */
    public static function toJSON($obj)
    {
        return json_decode(json_encode($obj), true);
    }
}
