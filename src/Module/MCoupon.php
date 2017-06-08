<?php declare(strict_types=1);

namespace CouponPlugin\Module;

use CouponPlugin\Db\DbCoupon;
use CouponPlugin\Db\DbCoupons;
use CouponPlugin\ErrorException;
use CouponPlugin\Util\Date;
use CouponPlugin\Util\Uuid;

/**
 * Class MCoupon
 * @package CouponPlugin\Module
 */
class MCoupon extends mBase
{
    const COL_ID = DbCoupon::COL_ID;
    const COL_POST_TIME = DbCoupon::COL_POST_TIME;
    const COL_PUT_TIME = DbCoupon::COL_PUT_TIME;
    const COL_OWNER_ID = DbCoupon::COL_OWNER_ID;
    const COL_ACTIVITY_ID = DbCoupon::COL_ACTIVITY_ID;
    const COL_TEMPLATE_ID = DbCoupon::COL_TEMPLATE_ID;
    const COL_USED_COUNT = DbCoupon::COL_USED_COUNT;
    const COL_USED_TIME = DbCoupon::COL_USED_TIME;

    private function __construct()
    {
    }

    /**
     * @param string $owner_id
     * @param string $activity_id
     * @param string $template_id
     * @param int $second
     * @return DbCoupon
     * @throws ErrorException
     */
    public static function object(
        string $owner_id,
        string $activity_id,
        string $template_id,
        $second = 0
    ): DbCoupon {
        if (!Uuid::isValid($owner_id)) {
            throw new ErrorException('"owner_id" should not be empty: '.$owner_id);
        }

        if (!Uuid::isValid($activity_id)) {
            throw new ErrorException('"activity_id" should not be empty: '.$activity_id);
        }
        $activity = MActivity::get($activity_id);
        if (!$activity) {
            throw new ErrorException('"activity_id" should not be existed: '.$activity_id);
        }

        if (!Uuid::isValid($template_id)) {
            throw new ErrorException('"template_id" should not be empty: '.$template_id);
        }
        $template = MCouponTemplate::get($template_id);
        if (!$template) {
            throw new ErrorException('"template_id" should not be existed: '.$template_id);
        }

        $ins = new DbCoupon($owner_id, $activity, $template);
        if ($second > 0) {
            $ins->dead_time = Date::get_next_time($second);
        }

        return $ins;
    }

    public static function post(DbCoupon $obj): bool
    {
        if (!$obj) {
            throw new ErrorException('"obj" should not be null!');
        }

        if ($obj->countActivityCoupon() >= $obj->activity->coupon_limit) {
            return false;
        }

        if (!$obj->activity->increaseCouponUsed()) {
            return false;
        }

        return $obj->_beforePost()->post();
    }

    /**
     * @param string $id
     * @param array $columns
     * @param callback $callback
     * @return DbCoupon|null
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
     * @return DbCoupon|null
     */
    public static function get(string $id)
    {
        $ins = new DbCoupon();
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
    public static function list(array $where = null, $limit = 0, $page = 0)
    {
        $ins = new DbCoupons();

        return $ins->select($where, $limit, $page);
    }
}
