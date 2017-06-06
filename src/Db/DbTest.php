<?php declare(strict_types=1);

namespace CouponPlugin\Db;

use CouponPlugin\Util\Date;

class DbTest extends dbBaseId
{
    const COL_NAME = 'name';
    const COL_EMAIL = 'email';
    const COL_POST_TIME = 'post_time';
    const COL_PUT_TIME = 'put_time';

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $post_time;

    /**
     * @var string
     */
    public $put_time;

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
    protected function getArray(): array
    {
        return [
            self::COL_NAME => $this->name,
            self::COL_EMAIL => $this->email,
            self::COL_POST_TIME => $this->post_time,
            self::COL_PUT_TIME => $this->put_time,
        ];
    }

    /**
     * @param $data
     * @return DbTest
     */
    protected function getInstance($data)
    {
        $this->name = $data[self::COL_NAME];
        $this->email = $data[self::COL_EMAIL];
        $this->post_time = $data[self::COL_POST_TIME];
        $this->put_time = $data[self::COL_PUT_TIME];

        return $this;
    }

    /**
     * @return bool
     */
    public function post(): bool
    {
        $this->post_time = Date::get_now_time();
        $this->put_time = Date::get_now_time();

        return parent::post();
    }

    /**
     * @param array|string $columns
     * @return bool
     */
    public function put($columns = []): bool
    {
        $this->put_time = Date::get_now_time();
        array_push($columns, self::COL_PUT_TIME);

        return parent::put($columns);
    }
}
