<?php declare(strict_types=1);

namespace CouponPlugin\Db;

class DbTest extends dbBaseId
{
    const COL_NAME = 'name';
    const COL_EMAIL = 'email';

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    protected function getTableName(): string
    {
        return 'test';
    }

    /**
     * @param int $type
     * @return bool
     */
    public function valid($type): bool
    {
        switch ($type) {
            case self::_TypeDbInsert:
                return !empty($this->name) && !empty($this->email);
        }

        return false;
    }

    /**
     * @return bool
     */
    public function insert(): bool
    {
        return parent::_insert(
            [
                self::COL_NAME => $this->name,
                self::COL_EMAIL => $this->email,
            ]
        );
    }

    /**
     * @param $data
     * @return bool
     */
    protected function toInstance($data): bool
    {
        $this->id = $data[self::COL_ID];
        $this->name = $data[self::COL_NAME];
        $this->email = $data[self::COL_EMAIL];

        return true;
    }

    /**
     * @param array $where
     * @return bool
     */
    public function get($where): bool
    {
        return parent::_get($where);
    }

    /**
     * @param $id
     * @return bool
     */
    public function getById($id): bool
    {
        return parent::_getById($id);
    }
}
