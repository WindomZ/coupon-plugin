<?php declare(strict_types=1);

namespace CouponPlugin\Test\Model;

use CouponPlugin\Coupon;
use CouponPlugin\Db\DbActivity;
use CouponPlugin\Db\DbCoupon;
use CouponPlugin\Db\DbCouponTemplate;
use CouponPlugin\Db\DbPack;
use CouponPlugin\Model\MActivity;
use CouponPlugin\Model\MCoupon;
use CouponPlugin\Model\MCouponTemplate;
use CouponPlugin\Model\MPack;
use PHPUnit\Framework\TestCase;

/**
 * Class MTest
 * @package CouponPlugin\Test\Model
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

        $list = MActivity::list([MActivity::COL_NAME => 'name'], 10, 0);
        if (!$list || !$list['size']) {
            $obj = MActivity::object(
                'name',
                'note',
                10000,
                1,
                0
            );

            $obj->class = -1;
            $obj->kind = 3;
            $this->assertFalse($obj->valid($obj::_TypeDbPost));

            $obj->class = 1;
            $this->assertTrue($obj->valid($obj::_TypeDbPost));

            $this->assertTrue(MActivity::post($obj));

            $list = MActivity::list([MActivity::COL_NAME => 'name'], 10, 0);
        }
        self::assertNotEmpty($list);
        self::assertEquals(sizeof($list), 4);
        self::assertEquals($list['size'], 1);

        $ins = $list['data'][0];
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

        $this->assertTrue(MActivity::disable($ins));
        $this->assertTrue(MActivity::disable($ins->id));

        $ins->valid = true;
        MActivity::put(
            $ins,
            [MActivity::COL_VALID]
        );

        $ins = MActivity::get($ins->id);
        self::assertNotEmpty($ins);
        $this->assertTrue($ins->valid);

        return $ins;
    }

    /**
     * @return DbCouponTemplate
     */
    public function testMCouponTemplate()
    {
        $coupon = Coupon::getInstance();
        self::assertNotEmpty($coupon);

        $list = MCouponTemplate::list([MCouponTemplate::COL_NAME => 'name'], 10, 0);
        if (!$list || !$list['size']) {
            $obj = MCouponTemplate::object(
                'name',
                '这是描述',
                100,
                200,
                0
            );

            $obj->class = -1;
            $obj->kind = 3;
            $this->assertFalse($obj->valid($obj::_TypeDbPost));

            $obj->class = 1;
            $this->assertTrue($obj->valid($obj::_TypeDbPost));

            $this->assertTrue(MCouponTemplate::post($obj));

            $list = MCouponTemplate::list([MCouponTemplate::COL_NAME => 'name'], 10, 0);
        }
        self::assertNotEmpty($list);
        self::assertEquals(sizeof($list), 4);
        self::assertEquals($list['size'], 1);

        $ins = $list['data'][0];
        self::assertNotEmpty($ins);

        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->desc, '这是描述');
        $this->assertEquals($ins->min_amount, 100);
        $this->assertEquals($ins->offer_amount, 200);

        $ins = MCouponTemplate::get($ins->id);
        self::assertNotEmpty($ins);

        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->desc, '这是描述');
        $this->assertEquals($ins->min_amount, 100);
        $this->assertEquals($ins->offer_amount, 200);

        $this->assertTrue(MCouponTemplate::disable($ins));
        $this->assertTrue(MCouponTemplate::disable($ins->id));

        $ins->valid = true;
        MCouponTemplate::put(
            $ins,
            [MCouponTemplate::COL_VALID]
        );

        $ins = MCouponTemplate::get($ins->id);
        self::assertNotEmpty($ins);
        $this->assertTrue($ins->valid);

        return $ins;
    }

    /**
     * @depends testMActivity
     * @depends testMCouponTemplate
     * @param DbActivity $activity
     * @param DbCouponTemplate $template
     * @return DbPack|null
     */
    public function testMPack($activity, $template)
    {
        self::assertNotEmpty($activity);
        self::assertNotEmpty($template);

        $coupon = Coupon::getInstance();
        self::assertNotEmpty($coupon);

        $list = MPack::list(
            [MPack::where(MPack::WHERE_NEQ, MPack::COL_NAME) => '!name'],
            10,
            0
        );
        if (!$list || !$list['size']) {
            $obj = MPack::object(
                'name',
                $activity->id,
                $template->id
            );

            $this->assertTrue(MPack::post($obj));

            $list = MPack::list([MPack::COL_NAME => 'name'], 10, 0);
        }
        self::assertNotEmpty($list);
        self::assertEquals(sizeof($list), 4);
        self::assertEquals($list['size'], 1);

        $ins = $list['data'][0];
        self::assertNotEmpty($ins);

        $this->assertEquals($ins->activity_id, $activity->id);
        $this->assertEquals($ins->template_id, $template->id);
        $this->assertEquals($ins->name, 'name');

        $ins = MPack::get($ins->id);
        self::assertNotEmpty($ins);

        $this->assertEquals($ins->activity_id, $activity->id);
        $this->assertEquals($ins->template_id, $template->id);
        $this->assertEquals($ins->name, 'name');

        $this->assertTrue(MPack::disable($ins));
        $this->assertTrue(MPack::disable($ins->id));

        $ins->valid = true;
        MPack::put(
            $ins,
            [MPack::COL_VALID]
        );

        return $ins;
    }

    /**
     * @depends testMPack
     * @param DbPack $pack
     * @return DbCoupon|null
     */
    public function testMCoupon($pack)
    {
        self::assertNotEmpty($pack);

        $coupon = Coupon::getInstance();
        self::assertNotEmpty($coupon);

        $list = MCoupon::list(
            [MCoupon::where(MCoupon::WHERE_NEQ, MCoupon::COL_NAME) => 'name!'],
            10,
            0
        );
        if (!$list || !$list['size']) {
            $obj = MCoupon::object(
                $pack->id,
                $pack->id
            );

            $obj->class = -1;
            $obj->kind = 3;
            $this->assertFalse($obj->valid($obj::_TypeDbPost));

            $obj->class = 1;
            $this->assertTrue($obj->valid($obj::_TypeDbPost));

            $this->assertTrue(MCoupon::post($obj));

            $list = MCoupon::list([MCoupon::COL_NAME => 'name'], 10, 0);
        }
        self::assertNotEmpty($list);
        self::assertEquals(sizeof($list), 4);
        self::assertEquals($list['size'], 1);

        $ins = $list['data'][0];
        self::assertNotEmpty($ins);

        $this->assertEquals($ins->activity_id, $pack->activity_id);
        $this->assertEquals($ins->template_id, $pack->template_id);
        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->desc, '这是描述');
        $this->assertEquals($ins->min_amount, 100);
        $this->assertEquals($ins->offer_amount, 200);

        $ins = MCoupon::get($ins->id);
        self::assertNotEmpty($ins);

        $this->assertEquals($ins->activity_id, $pack->activity_id);
        $this->assertEquals($ins->template_id, $pack->template_id);
        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->desc, '这是描述');
        $this->assertEquals($ins->min_amount, 100);
        $this->assertEquals($ins->offer_amount, 200);

        $this->assertTrue($ins->used_count == 0 || $ins->used_count == 1);

        $this->assertTrue(MCoupon::disable($ins));
        $this->assertTrue(MCoupon::disable($ins->id));

        $ins->used_count = 0;
        $ins->valid = true;
        MCoupon::put(
            $ins,
            [MCoupon::COL_USED_COUNT, MCoupon::COL_VALID]
        );

        $this->assertTrue(MCoupon::use($ins));

        return $ins;
    }
}
