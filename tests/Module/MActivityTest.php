<?php declare(strict_types=1);

namespace CouponPlugin\Test\Module;

use CouponPlugin\Coupon;
use CouponPlugin\Db\DbActivity;
use CouponPlugin\Module\MActivity;
use PHPUnit\Framework\TestCase;

class MActivityTest extends TestCase
{
    /**
     * @return DbActivity
     */
    public function testMActivity()
    {
        $coupon = Coupon::getInstance();
        self::assertNotEmpty($coupon);

        $list = MActivity::list([DbActivity::COL_NAME => 'name'], 10, 0);
        if (!$list) {
            $this->assertTrue(
                MActivity::post(
                    'name',
                    'note',
                    10000,
                    1,
                    0
                )
            );
            $list = MActivity::list([DbActivity::COL_NAME => 'name'], 10, 0);
        }
        self::assertNotEmpty($list);
        self::assertEquals(sizeof($list), 1);

        $ins = $list[0];
        self::assertNotEmpty($ins);

        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->note, 'note');
        $this->assertEquals($ins->coupon_size, 10000);
        $this->assertEquals($ins->coupon_limit, 1);

        $ins = MActivity::get($ins->id);
        self::assertNotEmpty($ins);

        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->note, 'note');
        $this->assertEquals($ins->coupon_size, 10000);
        $this->assertEquals($ins->coupon_limit, 1);

        MActivity::put(
            $ins->id,
            function ($v) {
                self::assertNotEmpty($v);
            }
        );

        return $ins;
    }
}
