<?php declare(strict_types=1);

namespace CouponPlugin\Db;

use CouponPlugin\Coupon;

/**
 * Class dbBaseList
 * @package CouponPlugin\Db
 */
abstract class dbBaseList
{
    /**
     * @var array
     */
    protected $list = array();

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->list;
    }

    /**
     * @var int
     */
    protected $size = 0;

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return string
     */
    abstract protected function getTableName(): string;

    /**
     * @return \CouponPlugin\Database
     */
    protected function getDb()
    {
        return Coupon::getInstance()->getDb();
    }

    /**
     * @param $data
     * @return object
     */
    abstract protected function addInstance($data);

    /**
     * @param array|null $where
     * @param int $limit
     * @param int $page
     * @return bool
     */
    protected function _select(array $where = null, int $limit = 0, int $page = 0)
    {
        if ($limit > 0) {
            if (!$where) {
                $where = array();
            }
            if ($page > 0) {
                $where['LIMIT'] = [$limit * $page, $limit];
            } else {
                $where['LIMIT'] = $limit;
            }
        }

        $data = $this->getDb()->select($this->getTableName(), '*', $where);

        if (!$data || gettype($data) !== 'array') {
            return false;
        }

        foreach ($data as $item) {
            if (empty($this->addInstance($item))) {
                return false;
            }
        }

        $this->size = $this->getDb()->count($this->getTableName(), $where);

        return true;
    }

    /**
     * @param array|null $where
     * @param int $limit
     * @param int $page
     * @return array|null
     */
    public function select(array $where = null, int $limit = 0, int $page = 0)
    {
        if ($this->_select($where, $limit, $page)) {
            return ['data' => $this->getList(), 'size' => $this->getSize()];
        }

        return null;
    }
}
