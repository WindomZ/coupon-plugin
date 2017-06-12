<?php declare(strict_types=1);

namespace CouponPlugin\Db;

/**
 * Class DbPack
 * @package CouponPlugin\Db
 */
class DbPack extends dbBaseDate
{
    const COL_NAME = 'name';
    const COL_ACTIVITY_ID = 'activity_id';
    const COL_TEMPLATE_ID = 'template_id';
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
    public $level = 0;

    /**
     * @var bool
     */
    public $valid = true;

    /**
     * @var string
     */
    public $dead_time;

    /**
     * DbPack constructor.
     * @param string $name
     * @param DbActivity|null $activity
     * @param DbCouponTemplate|null $template
     */
    public function __construct(
        string $name = '',
        DbActivity $activity = null,
        DbCouponTemplate $template = null
    ) {
        $this->name = $name;

        if ($activity && $template) {
            $this->activity_id = $activity->id;
            $this->activity = $activity;
            $this->template_id = $template->id;
            $this->template = $template;
            $this->level = $activity->level;
            $this->valid = $activity->valid;
            $this->dead_time = $activity->dead_time;
        }
    }

    /**
     * @return string
     */
    protected function getTableName(): string
    {
        return 'pack';
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
                    && $this->validUuid($this->activity_id)
                    && $this->validUuid($this->template_id)
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
                self::COL_ACTIVITY_ID => $this->activity_id,
                self::COL_TEMPLATE_ID => $this->template_id,
                self::COL_LEVEL => $this->level,
                self::COL_VALID => $this->valid,
                self::COL_DEAD_TIME => $this->dead_time,
            ]
        );
    }

    /**
     * @param $data
     * @return DbPack
     */
    public function toInstance($data)
    {
        parent::toInstance($data);

        $this->name = $data[self::COL_NAME];
        $this->activity_id = $data[self::COL_ACTIVITY_ID];
        $this->template_id = $data[self::COL_TEMPLATE_ID];
        $this->level = $data[self::COL_LEVEL];
        $this->valid = !empty($data[self::COL_VALID]);
        $this->dead_time = $data[self::COL_DEAD_TIME];

        return $this;
    }
}
