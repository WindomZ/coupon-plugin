<?php declare(strict_types=1);

namespace CouponPlugin\Db;

use CouponPlugin\Coupon;
use CouponPlugin\ErrorException;

abstract class dbBase
{
    abstract protected function getTableName(): string;

    const _TypeDbPost = 1;
    const _TypeDbPut = 2;

    /**
     * @param int $type
     * @return bool
     */
    abstract public function valid($type): bool;

    /**
     * @return bool
     */
    abstract public function post(): bool;

    /**
     * @param array|string $columns
     * @return bool
     */
    abstract public function put($columns = []): bool;

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
     * @return object
     */
    abstract protected function toInstance($data);

    protected function getDb()
    {
        return Coupon::getInstance()->getDb();
    }

    /**
     * @param array $data
     * @return bool
     * @throws ErrorException
     */
    protected function _post($data): bool
    {
        if (!$this->valid(self::_TypeDbPost)) {
            var_dump($this);
            throw new ErrorException('Invalid insert object!');
        }

        return !empty($this->getDb()->insert($this->getTableName(), $data));
    }

    /**
     * @param array $data
     * @return bool
     * @throws ErrorException
     */
    protected function _put($data): bool
    {
        if (!$this->valid(self::_TypeDbPut)) {
            var_dump($this);
            throw new ErrorException('Invalid update object!');
        }

        return !empty($this->getDb()->update($this->getTableName(), $data));
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

        return !empty($this->toInstance($data));
    }
}
