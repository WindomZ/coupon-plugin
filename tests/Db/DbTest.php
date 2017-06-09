<?php declare(strict_types=1);

namespace CouponPlugin\Test\Db;

use CouponPlugin\Coupon;

use CouponPlugin\Db\DbActivity;
use CouponPlugin\Db\DbCoupon;
use CouponPlugin\Db\DbCouponTemplate;
use CouponPlugin\Util\Date;
use PHPUnit\Framework\TestCase;

class DbTest extends TestCase
{
    /**
     * @return DbActivity
     */
    public function testDbActivity()
    {
        $coupon = Coupon::getInstance();
        self::assertNotEmpty($coupon);

        $ins = new DbActivity();

        if ($ins->get([DbActivity::COL_NAME => 'name'])) {
            $this->assertEquals($ins->name, 'name');
            $this->assertEquals($ins->note, 'note');
            $this->assertEquals($ins->coupon_size, 10000);
            $this->assertEquals($ins->coupon_limit, 1);

            $ins->_beforePut()->put();
        } else {
            $ins->name = 'name';
            $ins->note = 'note';
            $ins->class = 0;
            $ins->kind = 1;
            $ins->coupon_size = 10000;
            $ins->coupon_limit = 1;
            $ins->dead_time = Date::get_now_time();

            $this->assertTrue($ins->_beforePost()->post());
        }

        $id = $ins->id;
        $ins = new DbActivity();
        $this->assertTrue($ins->getById($id));
        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->note, 'note');
        $this->assertEquals($ins->coupon_size, 10000);
        $this->assertEquals($ins->coupon_limit, 1);

        return $ins;
    }

    /**
     * @return DbCouponTemplate
     */
    public function testDbCouponTemplate()
    {
        $coupon = Coupon::getInstance();
        self::assertNotEmpty($coupon);

        $ins = new DbCouponTemplate();

        if ($ins->get([DbCouponTemplate::COL_NAME => 'name'])) {
            $this->assertEquals($ins->name, 'name');
            $this->assertEquals($ins->desc, 'desc');
            $this->assertEquals($ins->min_amount, 100);
            $this->assertEquals($ins->offer_amount, 200);

            $ins->_beforePut()->put();
        } else {
            $ins->name = 'name';
            $ins->desc = 'desc';
            $ins->class = 0;
            $ins->kind = 1;
            $ins->min_amount = 100;
            $ins->offer_amount = 200;
            $ins->dead_time = Date::get_now_time();

            $this->assertTrue($ins->_beforePost()->post());
        }

        $id = $ins->id;
        $ins = new DbCouponTemplate();
        $this->assertTrue($ins->getById($id));
        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->desc, 'desc');
        $this->assertEquals($ins->min_amount, 100);
        $this->assertEquals($ins->offer_amount, 200);

        return $ins;
    }

    /**
     * @depends testDbActivity
     * @depends testDbCouponTemplate
     * @param DbActivity $activity
     * @param DbCouponTemplate $template
     */
    public function testDbCoupon($activity, $template)
    {
        self::assertNotEmpty($activity);
        self::assertNotEmpty($template);

        $coupon = Coupon::getInstance();
        self::assertNotEmpty($coupon);

        $ins = new DbCoupon();

        if ($ins->get([DbCoupon::COL_TEMPLATE_ID => $template->id])) {
            $this->assertEquals($ins->owner_id, $template->id);
            $this->assertEquals($ins->activity_id, $activity->id);
            $this->assertEquals($ins->template_id, $template->id);
            $this->assertEquals($ins->name, 'name');
            $this->assertEquals($ins->desc, 'desc');
            $this->assertEquals($ins->min_amount, 100);
            $this->assertEquals($ins->offer_amount, 200);

            $ins->_beforePut()->put();
        } else {
            $ins->owner_id = $template->id;
            $ins->activity_id = $activity->id;
            $ins->template_id = $template->id;
            $ins->name = 'name';
            $ins->desc = 'desc';
            $ins->class = 0;
            $ins->kind = 1;
            $ins->min_amount = 100;
            $ins->offer_amount = 200;
            $ins->dead_time = Date::get_now_time();

            $this->assertTrue($ins->_beforePost()->post());
        }

        $id = $ins->id;
        $ins = new DbCoupon();
        $this->assertTrue($ins->getById($id));
        $this->assertEquals($ins->owner_id, $template->id);
        $this->assertEquals($ins->activity_id, $activity->id);
        $this->assertEquals($ins->template_id, $template->id);
        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->desc, 'desc');
        $this->assertEquals($ins->min_amount, 100);
        $this->assertEquals($ins->offer_amount, 200);
    }
}
