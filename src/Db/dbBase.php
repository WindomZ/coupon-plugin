<?php declare(strict_types=1);

namespace CouponPlugin\Db;

use CouponPlugin\Coupon;
use CouponPlugin\ErrorException;

/**
 * Class dbBase
 * @package CouponPlugin\Db
 */
abstract class dbBase
{
    /**
     * @return string
     */
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

    /**
     * @return \CouponPlugin\Database
     */
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

        $this->getDb()->insert($this->getTableName(), $data);
        if (!$this->getDb()->id()) {
            $err = $this->getDb()->error();
            throw new ErrorException(empty($err) ? 'SQL insert error!' : $err[2]);
        }

        return true;
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
    protected function _get(array $where = null)
    {
        $data = $this->getDb()->get($this->getTableName(), '*', $where);
        if (!$data) {
            return false;
        }

        return !empty($this->toInstance($data));
    }

    /**
     * @param array|null $where
     * @return int
     */
    protected function _count(array $where = null): int
    {
        $count = $this->getDb()->count($this->getTableName(), $where);
        if (!$count) {
            return -1;
        }

        return $count;
    }
}
