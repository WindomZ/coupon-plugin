<?php declare(strict_types=1);

namespace CouponPlugin\Db;

use CouponPlugin\ErrorException;
use CouponPlugin\Util\Date;
use CouponPlugin\Util\Uuid;

/**
 * Class DbCoupon
 * @package CouponPlugin\Db
 */
class DbCoupon extends DbCouponTemplate
{
    const COL_OWNER_ID = 'owner_id';
    const COL_ACTIVITY_ID = 'activity_id';
    const COL_TEMPLATE_ID = 'template_id';
    const COL_USED_COUNT = 'used_count';
    const COL_USED_TIME = 'used_time';

    /**
     * @var string
     */
    public $owner_id;

    /**
     * @var string
     */
    public $activity_id;

    /**
     * @var string
     */
    public $template_id;

    /**
     * @var int
     */
    public $used_count = 0;

    /**
     * @var string
     */
    public $used_time;

    public function __construct(
        $owner_id = '',
        $activity_id = '',
        DbCouponTemplate $template = null
    ) {
        if ($template) {
            parent::__construct(
                $template->name,
                $template->desc,
                $template->min_amount,
                $template->offer_amount
            );
            $this->template_id = $template->id;
            $this->valid = $template->valid;
            $this->dead_time = $template->dead_time;
        } else {
            parent::__construct();
        }

        $this->owner_id = $owner_id;
        $this->activity_id = $activity_id;
    }

    /**
     * @return string
     */
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
            case self::_TypeDbPost:
            case self::_TypeDbPut:
                return parent::valid($type)
                    && Uuid::isValid($this->owner_id) && Uuid::isValid($this->activity_id)
                    && Uuid::isValid($this->template_id)
                    && $this->used_count >= 0 && !empty($this->used_time);
        }

        return false;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                self::COL_OWNER_ID => $this->owner_id,
                self::COL_ACTIVITY_ID => $this->activity_id,
                self::COL_TEMPLATE_ID => $this->template_id,
                self::COL_USED_COUNT => $this->used_count,
                self::COL_USED_TIME => $this->used_time,
            ]
        );
    }

    /**
     * @param $data
     * @return DbCoupon
     */
    public function toInstance($data)
    {
        parent::toInstance($data);

        $this->owner_id = $data[self::COL_OWNER_ID];
        $this->activity_id = $data[self::COL_ACTIVITY_ID];
        $this->template_id = $data[self::COL_TEMPLATE_ID];
        $this->used_count = $data[self::COL_USED_COUNT];
        $this->used_time = $data[self::COL_USED_TIME];

        return $this;
    }

    /**
     * @return bool
     */
    public function post(): bool
    {
        $this->used_time = Date::get_now_time();

        return parent::post();
    }

    /**
     * @return int
     * @throws ErrorException
     */
    public function countActivityCoupon(): int
    {
        if (!Uuid::isValid($this->owner_id)) {
            throw new ErrorException('"owner_id" should not be empty: '.$this->owner_id);
        }
        if (!Uuid::isValid($this->activity_id)) {
            throw new ErrorException('"activity_id" should not be empty: '.$this->activity_id);
        }

        return $this->_count(
            [
                self::COL_OWNER_ID => $this->owner_id,
                self::COL_ACTIVITY_ID => $this->activity_id,
            ]
        );
    }
}
