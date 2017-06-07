<?php declare(strict_types=1);

namespace CouponPlugin\Test\Db;

use CouponPlugin\Db\DbTest;
use CouponPlugin\Coupon;

use PHPUnit\Framework\TestCase;

class DbTestTest extends TestCase
{
    /**
     * @return DbTest
     */
    public function testDbTest()
    {
        $coupon = Coupon::getInstance();
        self::assertNotEmpty($coupon);

        $ins = new DbTest();
        if ($ins->get([DbTest::COL_NAME => 'name'])) {
            $this->assertEquals($ins->name, 'name');
            $this->assertEquals($ins->email, 'email');

            $ins->put();
        } else {
            $ins->name = 'name';
            $ins->email = 'email';

            $this->assertTrue($ins->post());
        }

        $id = $ins->id;
        $ins = new DbTest();
        $this->assertTrue($ins->getById($id));
        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->email, 'email');

        return $ins;
    }
}
