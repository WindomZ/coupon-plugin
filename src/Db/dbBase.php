<?php declare(strict_types=1);

namespace CouponPlugin\Db;

use CouponPlugin\Coupon;
use Noodlehaus\ErrorException;

abstract class dbBase
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

    /**
     * @return array
     */
    abstract protected function toArray(): array;

    /**
     * @param $data
     * @return bool
     */
    abstract protected function toInstance($data): bool;

    protected function getDb()
    {
        return Coupon::getInstance()->getDb();
    }

    /**
     * @param array $data
     * @return bool
     * @throws ErrorException
     */
    protected function _insert($data): bool
    {
        if (!$this->valid(self::_TypeDbInsert)) {
            var_dump($this);
            throw new ErrorException('Invalid insert object!');
        }

        $result = $this->getDb()->insert($this->getTableName(), $data);

        return !empty($result);
    }

    /**
     * @param array $where
     * @return bool
     */
    protected function _get($where = null)
    {
        $data = $this->getDb()->get($this->getTableName(), '*', $where);
        if (!$data) {
            return false;
        }

        return $this->toInstance($data);
    }
}
