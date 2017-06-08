<?php declare(strict_types=1);

namespace CouponPlugin\Test\Module;

use CouponPlugin\Coupon;
use CouponPlugin\Db\DbActivity;
use CouponPlugin\Db\DbCoupon;
use CouponPlugin\Db\DbCouponTemplate;
use CouponPlugin\Module\MActivity;
use CouponPlugin\Module\MCoupon;
use CouponPlugin\Module\MCouponTemplate;
use PHPUnit\Framework\TestCase;

/**
 * Class MTest
 * @package CouponPlugin\Test\Module
 */
class MTest extends TestCase
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
                    MActivity::object(
                        'name',
                        'note',
                        10000,
                        1,
                        0
                    )
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
                    MCouponTemplate::object(
                        'name',
                        'desc',
                        100,
                        200,
                        0
                    )
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
     * @depends testMActivity
     * @depends testMCouponTemplate
     * @param DbActivity $activity
     * @param DbCouponTemplate $template
     * @return DbCoupon|null
     */
    public function testMCoupon($activity, $template)
    {
        self::assertNotEmpty($activity);
        self::assertNotEmpty($template);

        $coupon = Coupon::getInstance();
        self::assertNotEmpty($coupon);

        $list = MCoupon::list(
            [MCoupon::where(MCoupon::WHERE_NEQ, DbCoupon::COL_NAME) => 'name!'],
            10,
            0
        );
        if (!$list) {
            $this->assertTrue(
                MCoupon::post(
                    MCoupon::object(
                        $template->id,
                        $activity->id,
                        $template->id
                    )
                )
            );
            $list = MCoupon::list([DbCoupon::COL_NAME => 'name'], 10, 0);
        }
        self::assertNotEmpty($list);
        self::assertEquals(sizeof($list), 1);

        $ins = $list[0];
        self::assertNotEmpty($ins);

        $this->assertEquals($ins->activity_id, $activity->id);
        $this->assertEquals($ins->template_id, $template->id);
        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->desc, 'desc');
        $this->assertEquals($ins->min_amount, 100);
        $this->assertEquals($ins->offer_amount, 200);

        $ins = MCoupon::get($ins->id);
        self::assertNotEmpty($ins);

        $this->assertEquals($ins->activity_id, $activity->id);
        $this->assertEquals($ins->template_id, $template->id);
        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->desc, 'desc');
        $this->assertEquals($ins->min_amount, 100);
        $this->assertEquals($ins->offer_amount, 200);

        $this->assertTrue($ins->used_count == 0 || $ins->used_count == 1);

        MCoupon::put(
            $ins->id,
            function ($v) {
                self::assertNotEmpty($v);
                $v->used_count = 0;
                $v->valid = true;
            },
            [MCoupon::COL_USED_COUNT, MCoupon::COL_VALID]
        );

        $this->assertTrue(MCoupon::use($ins));

        return $ins;
    }
}
