<?php declare(strict_types=1);

namespace CouponPlugin\Db;

use CouponPlugin\Util\Date;

/**
 * Class dbBaseDate
 * @package CouponPlugin\Db
 */
abstract class dbBaseDate extends dbBaseId
{
    const COL_POST_TIME = 'post_time';
    const COL_PUT_TIME = 'put_time';

    /**
     * @var string
     */
    public $post_time;

    /**
     * @var string
     */
    public $put_time;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                self::COL_POST_TIME => $this->post_time,
                self::COL_PUT_TIME => $this->put_time,
            ]
        );
    }

    /**
     * @param $data
     * @return object
     */
    public function toInstance($data)
    {
        parent::toInstance($data);

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
        if (gettype($columns) === 'array') {
            array_push($columns, self::COL_PUT_TIME);
        }

        return parent::put($columns);
    }

    /**
     * @param string $column
     * @param int $count
     * @param array|string $columns
     * @return bool
     */
    public function increase(string $column, int $count, $columns = []): bool
    {
        $this->put_time = Date::get_now_time();

        return parent::increase($column, $count, $columns);
    }
}
