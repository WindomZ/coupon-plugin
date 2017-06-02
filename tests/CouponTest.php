<?php declare(strict_types=1);

namespace CouponPlugin\Test;

use CouponPlugin\Coupon;

use PHPUnit\Framework\TestCase;

class CouponTest extends TestCase
{
    public function testNewCoupon()
    {
        $coupon = new Coupon('./tests/config.yml');
        self::assertNotEmpty($coupon);

        self::assertEquals($coupon->getConfig()->get('host'), 'localhost');
        self::assertEquals($coupon->getConfig()->get('port'), 80);

        return $coupon;
    }
}
