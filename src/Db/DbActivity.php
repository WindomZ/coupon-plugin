<?php declare(strict_types=1);

namespace CouponPlugin\Db;

/**
 * Class DbActivity
 * @package CouponPlugin\Db
 */
class DbActivity extends dbBaseDate
{
    const COL_NAME = 'name';
    const COL_NOTE = 'note';
    const COL_VALID = 'valid';
    const COL_DEAD_TIME = 'dead_time';
    const COL_COUPON_SIZE = 'coupon_size';
    const COL_COUPON_USED = 'coupon_used';
    const COL_COUPON_LIMIT = 'coupon_limit';

    /**
     * @var string
     */
    public $name = '';

    /**
     * @var string
     */
    public $note = '';

    /**
     * @var bool
     */
    public $valid = true;

    /**
     * @var string
     */
    public $dead_time;

    /**
     * @var int
     */
    public $coupon_size = 0;

    /**
     * @var int
     */
    public $coupon_used = 0;

    /**
     * @var int
     */
    public $coupon_limit = 0;

    /**
     * @return string
     */
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
        switch ($type) {
            case self::_TypeDbPost:
            case self::_TypeDbPut:
                return !empty($this->name)
                    && $this->coupon_size >= 0 && $this->coupon_used >= 0;
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
                self::COL_NAME => $this->name,
                self::COL_NOTE => $this->note,
                self::COL_VALID => $this->valid,
                self::COL_DEAD_TIME => $this->dead_time,
                self::COL_COUPON_SIZE => $this->coupon_size,
                self::COL_COUPON_USED => $this->coupon_used,
                self::COL_COUPON_LIMIT => $this->coupon_limit,
            ]
        );
    }

    /**
     * @param $data
     * @return DbActivity
     */
    public function toInstance($data)
    {
        parent::toInstance($data);

        $this->name = $data[self::COL_NAME];
        $this->note = $data[self::COL_NOTE];
        $this->valid = $data[self::COL_VALID];
        $this->dead_time = $data[self::COL_DEAD_TIME];
        $this->coupon_size = $data[self::COL_COUPON_SIZE];
        $this->coupon_used = $data[self::COL_COUPON_USED];
        $this->coupon_limit = $data[self::COL_COUPON_LIMIT];

        return $this;
    }
}
