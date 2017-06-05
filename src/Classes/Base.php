<?php declare(strict_types=1);

namespace CouponPlugin\Classes;

use CouponPlugin\Coupon;

abstract class Base
{
    abstract protected function getTableName(): string;

    /**
     * @return bool
     */
    abstract public function insert(): bool;

    /**
     * @param array $where
     * @return bool
     */
    abstract public function get($where): bool;

    protected function _insert($datas): bool
    {
        $result = Coupon::getInstance()->getDb()
            ->insert($this->getTableName(), $datas);

        return !empty($result);
    }

    protected function _get($columns = null, $where = null)
    {
        return Coupon::getInstance()->getDb()
            ->get($this->getTableName(), $columns, $where);
    }
}
