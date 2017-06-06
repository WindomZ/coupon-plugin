<?php declare(strict_types=1);

namespace CouponPlugin\Db;

class DbCoupon extends dbBaseId
{
    const COL_OWNER_ID = 'owner_id';
    const COL_ACTIVITY_ID = 'activity_id';
    const COL_CLASS = 'class';
    const COL_KIND = 'kind';
    const COL_NAME = 'name';
    const COL_DESC = 'desc';
    const COL_MIN_AMOUNT = 'min_amount';
    const COL_OFFER_AMOUNT = 'offer_amount';
    const COL_VALID = 'valid';
    const COL_USED_COUNT = 'used_count';
    const COL_USED_TIME = 'used_time';
    const COL_POST_TIME = 'post_time';
    const COL_PUT_TIME = 'put_time';
    const COL_DEAD_TIME = 'dead_time';

    /**
     * @var string
     */
    public $owner_id;

    /**
     * @var string
     */
    public $activity_id;

    /**
     * @var int
     */
    public $class;

    /**
     * @var int
     */
    public $kind;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $desc;

    /**
     * @var float
     */
    public $min_amount;

    /**
     * @var float
     */
    public $offer_amount;

    /**
     * @var bool
     */
    public $valid;

    /**
     * @var int
     */
    public $used_count;

    /**
     * @var string
     */
    public $used_time;

    /**
     * @var string
     */
    public $post_time;

    /**
     * @var string
     */
    public $put_time;

    /**
     * @var string
     */
    public $dead_time;

    protected function getTableName(): string
    {
        return 'coupon';
    }

    /**
     * @param int $type
     * @return bool
     */
    public function valid($type): bool
    {
        switch ($type) {
            case self::_TypeDbInsert:
                return !empty($this->name) && !empty($this->tel);
        }

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
