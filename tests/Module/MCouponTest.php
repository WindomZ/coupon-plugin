<?php declare(strict_types=1);

namespace CouponPlugin\Test\Module;

use CouponPlugin\Coupon;
use CouponPlugin\Db\DbCoupon;
use CouponPlugin\Db\DbCouponTemplate;
use CouponPlugin\Module\MCoupon;
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

    /**
     * @depends testMCouponTemplate
     * @return DbCoupon
     */
    public function testMCoupon($template)
    {
        self::assertNotEmpty($template);

        $coupon = Coupon::getInstance();
        self::assertNotEmpty($coupon);

        $list = MCoupon::list([DbCoupon::COL_NAME => 'name'], 10, 0);
        if (!$list) {
            $this->assertTrue(
                MCoupon::post(
                    $template->id,
                    $template->id,
                    $template->id
                )
            );
            $list = MCoupon::list([DbCoupon::COL_NAME => 'name'], 10, 0);
        }
        self::assertNotEmpty($list);
        self::assertEquals(sizeof($list), 1);

        $ins = $list[0];
        self::assertNotEmpty($ins);

        $this->assertEquals($ins->template_id, $template->id);
        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->desc, 'desc');
        $this->assertEquals($ins->min_amount, 100);
        $this->assertEquals($ins->offer_amount, 200);

        $ins = MCoupon::get($ins->id);
        self::assertNotEmpty($ins);

        $this->assertEquals($ins->template_id, $template->id);
        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->desc, 'desc');
        $this->assertEquals($ins->min_amount, 100);
        $this->assertEquals($ins->offer_amount, 200);

        MCoupon::put(
            $ins->id,
            function ($v) {
                self::assertNotEmpty($v);
            }
        );

        return $ins;
    }
}
