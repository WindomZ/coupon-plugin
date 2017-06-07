<?php declare(strict_types=1);

namespace CouponPlugin\Test\Db;

use CouponPlugin\Coupon;

use CouponPlugin\Db\DbCoupon;
use CouponPlugin\Db\DbCouponTemplate;
use CouponPlugin\Util\Date;
use PHPUnit\Framework\TestCase;

class DbCouponTest extends TestCase
{
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

            $ins->put();
        } else {
            $ins->name = 'name';
            $ins->desc = 'desc';
            $ins->min_amount = 100;
            $ins->offer_amount = 200;
            $ins->dead_time = Date::get_now_time();

            $this->assertTrue($ins->post());
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
     * @depends testDbCouponTemplate
     * @param DbCouponTemplate $template
     */
    public function testDbCoupon($template)
    {
        $coupon = Coupon::getInstance();
        self::assertNotEmpty($coupon);

        $ins = new DbCoupon();

        if ($ins->get([DbCoupon::COL_TEMPLATE_ID => $template->id])) {
            $this->assertEquals($ins->owner_id, $template->id);
            $this->assertEquals($ins->activity_id, $template->id);
            $this->assertEquals($ins->template_id, $template->id);
            $this->assertEquals($ins->name, 'name');
            $this->assertEquals($ins->desc, 'desc');
            $this->assertEquals($ins->min_amount, 100);
            $this->assertEquals($ins->offer_amount, 200);

            $ins->put();
        } else {
            $ins->owner_id = $template->id;
            $ins->activity_id = $template->id;
            $ins->template_id = $template->id;
            $ins->name = 'name';
            $ins->desc = 'desc';
            $ins->min_amount = 100;
            $ins->offer_amount = 200;
            $ins->dead_time = Date::get_now_time();

            $this->assertTrue($ins->post());
        }

        $id = $ins->id;
        $ins = new DbCoupon();
        $this->assertTrue($ins->getById($id));
        $this->assertEquals($ins->owner_id, $template->id);
        $this->assertEquals($ins->activity_id, $template->id);
        $this->assertEquals($ins->template_id, $template->id);
        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->desc, 'desc');
        $this->assertEquals($ins->min_amount, 100);
        $this->assertEquals($ins->offer_amount, 200);
    }
}
