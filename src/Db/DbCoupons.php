<?php declare(strict_types=1);

namespace CouponPlugin\Db;

/**
 * Class DbCoupons
 * @package CouponPlugin\Db
 */
class DbCoupons extends dbBaseList
{
    /**
     * @return string
     */
    protected function getTableName(): string
    {
        return 'coupon';
    }

    /**
     * @param $data
     * @return object
     */
    protected function addInstance($data)
    {
        $ins = new DbCoupon();
        $ins = $ins->toInstance($data);
        array_push($this->list, $ins);

        return $ins;
    }
}
