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
    const COL_URL = 'url';
    const COL_CLASS = 'class';
    const COL_KIND = 'kind';
    const COL_COUPON_SIZE = 'coupon_size';
    const COL_COUPON_USED = 'coupon_used';
    const COL_COUPON_LIMIT = 'coupon_limit';
    const COL_LEVEL = 'level';
    const COL_VALID = 'valid';
    const COL_DEAD_TIME = 'dead_time';

    /**
     * @var string
     */
    public $name = '';

    /**
     * @var string
     */
    public $note = '';

    /**
     * @var string
     */
    public $url = '';

    /**
     * @var int
     */
    public $class = 0;

    /**
     * @var int
     */
    public $kind = 0;

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
     * @var int
     */
    public $level = 0;

    /**
     * @var bool
     */
    public $valid = true;

    /**
     * @var string
     */
    public $dead_time;

    public function __construct(
        $name = '',
        $note = '',
        $coupon_size = 0,
        $coupon_limit = 0
    ) {
        $this->name = $name;
        $this->note = $note;
        $this->coupon_size = $coupon_size;
        $this->coupon_limit = $coupon_limit;
    }

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
                return !empty($this->name)
                    && $this->class >= 0 && $this->kind >= 0
                    && $this->coupon_size >= 0 && $this->coupon_used >= 0
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
                self::COL_NAME => $this->name,
                self::COL_NOTE => $this->note,
                self::COL_URL => $this->url,
                self::COL_CLASS => $this->class,
                self::COL_KIND => $this->kind,
                self::COL_COUPON_SIZE => $this->coupon_size,
                self::COL_COUPON_USED => $this->coupon_used,
                self::COL_COUPON_LIMIT => $this->coupon_limit,
                self::COL_LEVEL => $this->level,
                self::COL_VALID => $this->valid,
                self::COL_DEAD_TIME => $this->dead_time,
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
        $this->url = $data[self::COL_URL];
        $this->class = $data[self::COL_CLASS];
        $this->kind = $data[self::COL_KIND];
        $this->coupon_size = $data[self::COL_COUPON_SIZE];
        $this->coupon_used = $data[self::COL_COUPON_USED];
        $this->coupon_limit = $data[self::COL_COUPON_LIMIT];
        $this->level = $data[self::COL_LEVEL];
        $this->valid = !empty($data[self::COL_VALID]);
        $this->dead_time = $data[self::COL_DEAD_TIME];

        return $this;
    }

    /**
     * @return bool
     */
    public function increaseCouponUsed(): bool
    {
        $this->getById($this->id);

        if ($this->coupon_size <= $this->coupon_used) {
            return false;
        }

        return $this->increase(self::COL_COUPON_USED, 1);
    }
}
