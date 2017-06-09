<?php declare(strict_types=1);

namespace CouponPlugin\Db;

/**
 * Class DbCouponTemplate
 * @package CouponPlugin\Db
 */
class DbCouponTemplate extends dbBaseDate
{
    const COL_CLASS = 'class';
    const COL_KIND = 'kind';
    const COL_PRODUCT_ID = 'product_id';
    const COL_NAME = 'name';
    const COL_DESC = 'desc';
    const COL_MIN_AMOUNT = 'min_amount';
    const COL_OFFER_AMOUNT = 'offer_amount';
    const COL_VALID = 'valid';
    const COL_DEAD_TIME = 'dead_time';

    /**
     * @var int
     */
    public $class = 0;

    /**
     * @var int
     */
    public $kind = 0;

    /**
     * @var string
     */
    public $product_id = '';

    /**
     * @var string
     */
    public $name = '';

    /**
     * @var string
     */
    public $desc = '';

    /**
     * @var float
     */
    public $min_amount = 0;

    /**
     * @var float
     */
    public $offer_amount = 0;

    /**
     * @var bool
     */
    public $valid = true;

    /**
     * @var string
     */
    public $dead_time;

    public function __construct($name = '', $desc = '', $min_amount = 0, $offer_amount = 0)
    {
        $this->name = $name;
        $this->desc = $desc;
        $this->min_amount = $min_amount;
        $this->offer_amount = $offer_amount;
    }

    /**
     * @return string
     */
    protected function getTableName(): string
    {
        return 'coupon_template';
    }

    /**
     * @param int $type
     * @return bool
     */
    public function valid($type): bool
    {
        switch ($type) {
            case self::_TypeDbPost:
                return !empty($this->name)
                    && $this->class >= 0 && $this->kind >= 0
                    && $this->min_amount >= 0 && $this->offer_amount >= 0
                    && !empty($this->dead_time);
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
                self::COL_CLASS => $this->class,
                self::COL_KIND => $this->kind,
                self::COL_PRODUCT_ID => $this->product_id,
                self::COL_NAME => $this->name,
                self::COL_DESC => $this->desc,
                self::COL_MIN_AMOUNT => $this->min_amount,
                self::COL_OFFER_AMOUNT => $this->offer_amount,
                self::COL_VALID => $this->valid,
                self::COL_DEAD_TIME => $this->dead_time,
            ]
        );
    }

    /**
     * @param $data
     * @return DbCouponTemplate
     */
    public function toInstance($data)
    {
        parent::toInstance($data);

        $this->class = $data[self::COL_CLASS];
        $this->kind = $data[self::COL_KIND];
        $this->product_id = $data[self::COL_PRODUCT_ID];
        $this->name = $data[self::COL_NAME];
        $this->desc = $data[self::COL_DESC];
        $this->min_amount = $data[self::COL_MIN_AMOUNT];
        $this->offer_amount = $data[self::COL_OFFER_AMOUNT];
        $this->valid = !empty($data[self::COL_VALID]);
        $this->dead_time = $data[self::COL_DEAD_TIME];

        return $this;
    }
}
