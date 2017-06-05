<?php declare(strict_types=1);

namespace CouponPlugin\Classes;

class Test extends Base
{
    const COL_ID = 'id';
    const COL_NAME = 'name';
    const COL_TEL = 'tel';

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $tel;

    protected function getTableName(): string
    {
        return 'test';
    }

    /**
     * @return bool
     */
    public function insert(): bool
    {
        return parent::_insert(
            [
                self::COL_NAME => $this->name,
                self::COL_TEL => $this->tel,
            ]
        );
    }

    /**
     * @param array $where
     * @return bool
     */
    public function get($where): bool
    {
        $data = parent::_get(
            [
                self::COL_ID,
                self::COL_NAME,
                self::COL_TEL,
            ],
            $where
        );
        if (!$data) {
            return false;
        }
        $this->id = $data[self::COL_ID];
        $this->name = $data[self::COL_NAME];
        $this->tel = $data[self::COL_TEL];

        return true;
    }
}
