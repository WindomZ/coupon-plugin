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
    protected function getInstance($data): bool
    {
        $this->name = $data[self::COL_NAME];
        $this->email = $data[self::COL_EMAIL];

        return true;
    }
}
