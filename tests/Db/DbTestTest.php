<?php declare(strict_types=1);

namespace CouponPlugin\Test\Db;

use CouponPlugin\Db\DbTest;
use CouponPlugin\Coupon;

use PHPUnit\Framework\TestCase;

class DbTestTest extends TestCase
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

        return $coupon;
    }

    /**
     * @depends testNewCoupon
     * @param Coupon $coupon
     */
    public function testDbTest($coupon)
    {
        self::assertNotEmpty($coupon);

        $test = new DbTest();
        if ($test->get([DbTest::COL_NAME => 'name'])) {
            $this->assertEquals($test->name, 'name');
            $this->assertEquals($test->email, 'email');

            $test->put();
        } else {
            $test->name = 'name';
            $test->email = 'email';

            $this->assertTrue($test->post());
        }

        $id = $test->id;
        $test = new DbTest();
        $this->assertTrue($test->getById($id));
        $this->assertEquals($test->name, 'name');
        $this->assertEquals($test->email, 'email');
    }
}
