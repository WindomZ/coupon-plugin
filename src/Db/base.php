<?php declare(strict_types=1);

namespace CouponPlugin\Db;

use CouponPlugin\Coupon;
use Noodlehaus\ErrorException;

abstract class base
{
    abstract protected function getTableName(): string;

    const _TypeDbInsert = 1;

    /**
     * @param int $type
     * @return bool
     */
    abstract public function valid($type): bool;

    /**
     * @return bool
     */
    abstract public function insert(): bool;

    /**
     * @param array $where
     * @return bool
     */
    abstract public function get($where): bool;

    protected function getDb()
    {
        return Coupon::getInstance()->getDb();
    }

    protected function _insert($datas): bool
    {
        if (!$this->valid(self::_TypeDbInsert)) {
            var_dump($this);
            throw new ErrorException('Invalid insert object!');
        }

        $result = $this->getDb()->insert($this->getTableName(), $datas);

        return !empty($result);
    }

    protected function _get($columns = null, $where = null)
    {
        return $this->getDb()->get($this->getTableName(), $columns, $where);
    }
}
