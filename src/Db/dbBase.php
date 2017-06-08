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
     * @var bool
     */
    private $beforePost = false;

    /**
     * @return $this
     */
    public function _beforePost()
    {
        $this->beforePost = true;

        return $this;
    }

    /**
     * @param array $data
     * @return bool
     * @throws ErrorException
     */
    protected function _post($data): bool
    {
        if (!$this->beforePost) {
            throw new ErrorException('Not ready to insert object!');
        }
        $this->beforePost = false;
        if (!$this->valid(self::_TypeDbPost)) {
            throw new ErrorException('Invalid insert object!');
        }

        $this->getDb()->insert($this->getTableName(), $data);
        $err = $this->getDb()->error();
        if ($err && sizeof($err) >= 2 && !empty($err[2])) {
            throw new ErrorException($err[2]);
        }

        return true;
    }

    /**
     * @var bool
     */
    private $beforePut = false;

    /**
     * @return $this
     */
    public function _beforePut()
    {
        $this->beforePut = true;

        return $this;
    }

    /**
     * @param array $data
     * @param array $where
     * @return bool
     * @throws ErrorException
     */
    protected function _put(array $data, array $where): bool
    {
        if (!$this->beforePut) {
            throw new ErrorException('Not ready to update object!');
        }
        $this->beforePut = false;
        if (!$this->valid(self::_TypeDbPut)) {
            throw new ErrorException('Invalid update object!');
        }

        return !empty($this->getDb()->update($this->getTableName(), $data, $where));
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

    /**
     * @param string $column
     * @param int $count
     * @param array $where
     * @return bool
     */
    protected function _increase(string $column, int $count, array $where): bool
    {
        if (empty($column) || empty($count)) {
            return false;
        }

        return $this->_beforePut()->_put([$column.'[+]' => $count], $where);
    }
}
