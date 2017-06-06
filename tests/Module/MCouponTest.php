<?php declare(strict_types=1);

namespace CouponPlugin\Test\Module;

use CouponPlugin\Coupon;
use CouponPlugin\Db\DbCouponTemplate;
use CouponPlugin\Module\MCouponTemplate;
use PHPUnit\Framework\TestCase;

class MCouponTest extends TestCase
{
    const ID = 'eb5ec8eb-c864-4376-9ff2-91828b0cf6ab';

    /**
     * @return DbCouponTemplate
     */
    public function testMCouponTemplate()
    {
        $coupon = Coupon::getInstance();
        self::assertNotEmpty($coupon);

        $ins = MCouponTemplate::get(self::ID);
        self::assertNotEmpty($ins);

        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->desc, 'desc');
        $this->assertEquals($ins->min_amount, 100);
        $this->assertEquals($ins->offer_amount, 200);

        MCouponTemplate::put(
            self::ID,
            function ($v) {
                self::assertNotEmpty($v);
            }
        );

        return $ins;
    }
}
