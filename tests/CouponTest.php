<?php declare(strict_types=1);

namespace CouponPlugin\Test;

use CouponPlugin\Coupon;

use PHPUnit\Framework\TestCase;

class CouponTest extends TestCase
{
    /**
     * @covers  Coupon::getInstance()
     * @return Coupon
     */
    public function testNewCoupon()
    {
        Coupon::$configPath = './tests/config.yml';
        $coupon = Coupon::getInstance();
        self::assertNotEmpty($coupon);

        self::assertEquals($coupon->getConfig()->get('host'), '127.0.0.1');
        self::assertEquals($coupon->getConfig()->get('port'), 80);

        self::assertEquals($coupon->getConfig()->get('database.host'), '127.0.0.1');
        self::assertEquals($coupon->getConfig()->get('database.port'), 3306);
        self::assertEquals($coupon->getConfig()->get('database.type'), 'mysql');
        self::assertEquals($coupon->getConfig()->get('database.name'), 'testdb');
        self::assertEquals($coupon->getConfig()->get('database.username'), 'root');
        self::assertEquals($coupon->getConfig()->get('database.password'), 'root');

        return $coupon;
    }
}
