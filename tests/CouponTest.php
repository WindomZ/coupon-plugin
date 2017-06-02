<?php declare(strict_types=1);

namespace CouponPlugin\Test;

use CouponPlugin\Coupon;

use PHPUnit\Framework\TestCase;

class CouponTest extends TestCase
{
    public function testNewCoupon()
    {
        $coupon = new Coupon();
        self::assertNotEmpty($coupon);

        return $coupon;
    }
}
