<?php declare(strict_types=1);

namespace CouponPlugin\Db;

use CouponPlugin\Util\Date;

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
        $template_id = '',
        $name = '',
        $desc = '',
        $min_amount = 0,
        $offer_amount = 0
    ) {
        parent::__construct($name, $desc, $min_amount, $offer_amount);

        $this->owner_id = $owner_id;
        $this->activity_id = $activity_id;
        $this->template_id = $template_id;
    }

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
                    && !empty($this->owner_id) && !empty($this->activity_id) && !empty($this->template_id)
                    && $this->used_count >= 0 && !empty($this->used_time);
        }

        return false;
    }

    /**
     * @return array
     */
    protected function getArray(): array
    {
        return array_merge(
            parent::getArray(),
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
    protected function getInstance($data)
    {
        parent::getInstance($data);

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
}
