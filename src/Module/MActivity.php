<?php declare(strict_types=1);

namespace CouponPlugin\Module;

use CouponPlugin\Db\DbActivities;
use CouponPlugin\Db\DbActivity;
use CouponPlugin\ErrorException;
use CouponPlugin\Util\Date;
use CouponPlugin\Util\Uuid;

/**
 * Class MActivity
 * @package CouponPlugin\Module
 */
class MActivity extends mBase
{
    const COL_ID = DbActivity::COL_ID;
    const COL_POST_TIME = DbActivity::COL_POST_TIME;
    const COL_PUT_TIME = DbActivity::COL_PUT_TIME;
    const COL_NAME = DbActivity::COL_NAME;
    const COL_NOTE = DbActivity::COL_NOTE;
    const COL_URL = DbActivity::COL_URL;
    const COL_CLASS = DbActivity::COL_CLASS;
    const COL_KIND = DbActivity::COL_KIND;
    const COL_COUPON_SIZE = DbActivity::COL_COUPON_SIZE;
    const COL_COUPON_USED = DbActivity::COL_COUPON_USED;
    const COL_COUPON_LIMIT = DbActivity::COL_COUPON_LIMIT;
    const COL_LEVEL = DbActivity::COL_LEVEL;
    const COL_VALID = DbActivity::COL_VALID;
    const COL_DEAD_TIME = DbActivity::COL_DEAD_TIME;

    private function __construct()
    {
    }

    /**
     * @param string $name
     * @param string $note
     * @param int $coupon_size
     * @param int $coupon_limit
     * @param int $second
     * @return DbActivity
     * @throws ErrorException
     */
    public static function object(
        string $name,
        string $note = '',
        $coupon_size = 0,
        $coupon_limit = 0,
        $second = 0
    ): DbActivity {
        if (empty($name)) {
            throw new ErrorException('"name" should not be empty: '.$name);
        }

        if ($coupon_size < 0) {
            $coupon_size = 0;
        }
        if ($coupon_limit < 0) {
            $coupon_limit = 0;
        }

        $ins = new DbActivity($name, $note, $coupon_size, $coupon_limit);
        $ins->dead_time = Date::get_next_time($second);

        return $ins;
    }

    /**
     * @param DbActivity $obj
     * @return bool
     * @throws ErrorException
     */
    public static function post(DbActivity $obj): bool
    {
        if (!$obj) {
            throw new ErrorException('"obj" should not be null!');
        }

        return $obj->_beforePost()->post();
    }

    /**
     * @param string $id
     * @param array $columns
     * @param callback $callback
     * @return DbActivity|null
     * @throws ErrorException
     */
    public static function put(string $id, $callback = null, $columns = [])
    {
        if (!Uuid::isValid($id)) {
            throw new ErrorException('"id" should not be empty: '.$id);
        }

        $ins = self::get($id);
        if (!$ins) {
            throw new ErrorException('Not found id: '.$id);
        }

        if ($callback) {
            $callback($ins);
        }

        $ins->_beforePut()->put($columns);

        return $ins;
    }

    /**
     * @param string $id
     * @return DbActivity|null
     */
    public static function get(string $id)
    {
        $ins = new DbActivity();
        if (!$ins->getById($id)) {
            return null;
        }

        return $ins;
    }

    /**
     * @param array|null $where
     * @param int $limit
     * @param int $page
     * @return array|null
     */
    public static function list(array $where = null, int $limit = 0, int $page = 0)
    {
        return (new DbActivities())->select($where, $limit, $page);
    }

    /**
     * @param DbActivity|string $objOrId
     * @return DbActivity
     * @throws ErrorException
     */
    protected static function toObj($objOrId): DbActivity
    {
        if (!$objOrId) {
            throw new ErrorException('"objOrId" should not be null!');
        }

        $obj = null;
        if (gettype($objOrId) === 'string') {
            $obj = self::get($objOrId);
        } elseif ($objOrId instanceof DbActivity) {
            $obj = $objOrId;
        }

        if (!$obj) {
            throw new ErrorException('"obj" should not be null!');
        }

        return $obj;
    }

    /**
     * @param DbActivity|string $objOrId
     * @return bool
     * @throws ErrorException
     */
    public static function disable($objOrId): bool
    {
        $obj = self::toObj($objOrId);
        $obj->valid = false;

        return $obj->_beforePut()->put([self::COL_VALID]);
    }
}
