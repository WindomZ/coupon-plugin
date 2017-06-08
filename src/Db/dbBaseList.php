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
            return $this->getList();
        }

        return null;
    }
}
