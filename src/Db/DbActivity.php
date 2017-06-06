<?php declare(strict_types=1);

namespace CouponPlugin\Db;

class DbActivity extends dbBaseId
{
    const COL_NAME = 'name';
    const COL_NOTE = 'note';
    const COL_VALID = 'valid';
    const COL_POST_TIME = 'post_time';
    const COL_PUT_TIME = 'put_time';
    const COL_DEAD_TIME = 'dead_time';
    const COL_COUPON_SIZE = 'coupon_size';
    const COL_COUPON_USED = 'coupon_used';
    const COL_COUPON_UNI = 'coupon_uni';

    protected function getTableName(): string
    {
        return 'activity';
    }

    /**
     * @param int $type
     * @return bool
     */
    public function valid($type): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function insert(): bool
    {
        return false;
    }

    /**
     * @param array $where
     * @return bool
     */
    public function get($where): bool
    {
        return false;
    }
}
