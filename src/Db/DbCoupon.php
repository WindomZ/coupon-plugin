<?php declare(strict_types=1);

namespace CouponPlugin\Db;

use CouponPlugin\ErrorException;
use CouponPlugin\Util\Date;

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
     * @var DbActivity|null
     */
    public $activity = null;

    /**
     * @var string
     */
    public $template_id;

    /**
     * @var DbCouponTemplate|null
     */
    public $template = null;

    /**
     * @var int
     */
    public $used_count = 0;

    /**
     * @var string
     */
    public $used_time;

    /**
     * @var string
     */
    public $dead_time;

    /**
     * DbCoupon constructor.
     * @param string $owner_id
     * @param DbActivity|null $activity
     * @param DbCouponTemplate|null $template
     */
    public function __construct(
        $owner_id = '',
        DbActivity $activity = null,
        DbCouponTemplate $template = null
    ) {
        $this->owner_id = $owner_id;

        if ($activity && $template) {
            parent::__construct(
                $template->name,
                $template->desc,
                $template->min_amount,
                $template->offer_amount
            );
            $this->activity_id = $activity->id;
            $this->activity = $activity;
            $this->template_id = $template->id;
            $this->template = $template;
            $this->class = $template->class;
            $this->kind = $template->kind;
            $this->product_id = $template->product_id;
            $this->valid = $template->valid;
            $this->dead_time = $activity->dead_time;
        } else {
            parent::__construct();
        }
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
                return parent::valid($type)
                    && $this->validUuid($this->owner_id) && $this->validUuid($this->activity_id)
                    && $this->validUuid($this->template_id)
                    && $this->used_count >= 0 && !empty($this->dead_time);
            case self::_TypeDbPut:
                return $this->validId() && $this->valid(self::_TypeDbPost);
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
                self::COL_DEAD_TIME => $this->dead_time,
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
        $this->dead_time = $data[self::COL_DEAD_TIME];

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
        if (!$this->validUuid($this->owner_id)) {
            throw new ErrorException('"owner_id" should not be empty: '.$this->owner_id);
        }
        if (!$this->validUuid($this->activity_id)) {
            throw new ErrorException('"activity_id" should not be empty: '.$this->activity_id);
        }

        return $this->_count(
            [
                self::COL_OWNER_ID => $this->owner_id,
                self::COL_ACTIVITY_ID => $this->activity_id,
            ]
        );
    }

    /**
     * @return bool
     */
    public function increaseCouponUsed(): bool
    {
        $this->getById($this->id);

        if (!$this->valid || $this->used_count != 0) {
            return false;
        }

        $this->valid = false;

        return $this->increase(self::COL_USED_COUNT, 1, [self::COL_VALID]);
    }
}
