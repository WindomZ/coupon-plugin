<?php declare(strict_types=1);

namespace CouponPlugin\Test\Module;

use CouponPlugin\Coupon;
use CouponPlugin\Db\DbCouponTemplate;
use CouponPlugin\Module\MCouponTemplate;
use PHPUnit\Framework\TestCase;

class MCouponTest extends TestCase
{
    /**
     * @return DbCouponTemplate
     */
    public function testMCouponTemplate()
    {
        $coupon = Coupon::getInstance();
        self::assertNotEmpty($coupon);

        $list = MCouponTemplate::list([DbCouponTemplate::COL_NAME => 'name'], 10, 0);
        if (!$list) {
            $this->assertTrue(
                MCouponTemplate::post(
                    'name',
                    'desc',
                    100,
                    200,
                    0
                )
            );
            $list = MCouponTemplate::list([DbCouponTemplate::COL_NAME => 'name'], 10, 0);
        }
        self::assertNotEmpty($list);
        self::assertEquals(sizeof($list), 1);

        $ins = $list[0];
        self::assertNotEmpty($ins);

        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->desc, 'desc');
        $this->assertEquals($ins->min_amount, 100);
        $this->assertEquals($ins->offer_amount, 200);

        $ins = MCouponTemplate::get($ins->id);
        self::assertNotEmpty($ins);

        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->desc, 'desc');
        $this->assertEquals($ins->min_amount, 100);
        $this->assertEquals($ins->offer_amount, 200);

        MCouponTemplate::put(
            $ins->id,
            function ($v) {
                self::assertNotEmpty($v);
            }
        );

        return $ins;
    }
}
