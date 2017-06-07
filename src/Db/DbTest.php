<?php declare(strict_types=1);

namespace CouponPlugin\Db;

/**
 * Class DbTest
 * @package CouponPlugin\Db
 */
class DbTest extends dbBaseDate
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

    /**
     * @return string
     */
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
            case self::_TypeDbPost:
            case self::_TypeDbPut:
                return !empty($this->name) && !empty($this->email);
        }

        return false;
    }

    /**
     * @return array
     */
    public function getArray(): array
    {
        return array_merge(
            parent::getArray(),
            [
                self::COL_NAME => $this->name,
                self::COL_EMAIL => $this->email,
            ]
        );
    }

    /**
     * @param $data
     * @return DbTest
     */
    public function getInstance($data)
    {
        parent::getInstance($data);

        $this->name = $data[self::COL_NAME];
        $this->email = $data[self::COL_EMAIL];

        return $this;
    }
}
