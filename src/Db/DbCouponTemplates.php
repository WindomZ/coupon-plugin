<?php declare(strict_types=1);

namespace CouponPlugin\Db;

/**
 * Class DbCouponTemplates
 * @package CouponPlugin\Db
 */
class DbCouponTemplates extends dbBaseList
{
    /**
     * @return string
     */
    protected function getTableName(): string
    {
        return 'coupon_template';
    }

    /**
     * @param $data
     * @return object
     */
    protected function addInstance($data)
    {
        $ins = new DbCouponTemplate();
        $ins = $ins->getInstance($data);
        array_push($this->list, $ins);

        return $ins;
    }
}
