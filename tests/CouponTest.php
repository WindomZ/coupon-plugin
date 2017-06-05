<?php declare(strict_types=1);

namespace CouponPlugin\Test;

use CouponPlugin\Db\DbTest;
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
        $coupon = new Coupon('./tests/config.yml');
        self::assertNotEmpty($coupon);

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

    /**
     * @depends testNewCoupon
     * @param Coupon $coupon
     * @return array
     */
    public function testDbTest($coupon)
    {
        self::assertNotEmpty($coupon);

        $test = new DbTest();
        if ($test->get([DbTest::COL_NAME => 'name'])) {
            $this->assertEquals($test->name, 'name');
            $this->assertEquals($test->email, 'email');
        } else {
            $test->name = 'name';
            $test->email = 'email';
            $this->assertTrue($test->insert());
        }
    }
}
