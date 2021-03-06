<?php declare(strict_types=1);

namespace CouponPlugin\Model;

use CouponPlugin\Db\DbCoupon;
use CouponPlugin\Db\DbCoupons;
use CouponPlugin\ErrorException;
use CouponPlugin\Util\Uuid;

/**
 * Class MCoupon
 * @package CouponPlugin\Model
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

    const COL_CLASS = DbCoupon::COL_CLASS;
    const COL_KIND = DbCoupon::COL_KIND;
    const COL_PRODUCT_ID = DbCoupon::COL_PRODUCT_ID;
    const COL_NAME = DbCoupon::COL_NAME;
    const COL_DESC = DbCoupon::COL_DESC;
    const COL_MIN_AMOUNT = DbCoupon::COL_MIN_AMOUNT;
    const COL_OFFER_AMOUNT = DbCoupon::COL_OFFER_AMOUNT;
    const COL_VALID = DbCoupon::COL_VALID;
    const COL_DEAD_TIME = DbCoupon::COL_DEAD_TIME;

    private function __construct()
    {
    }

    /**
     * @param string $owner_id
     * @param string $pack_id
     * @return DbCoupon
     * @throws ErrorException
     */
    public static function object(
        string $owner_id,
        string $pack_id
    ): DbCoupon {
        if (!Uuid::isValid($owner_id)) {
            throw new ErrorException('"owner_id" should be UUID: '.$owner_id);
        }

        if (!Uuid::isValid($pack_id)) {
            throw new ErrorException('"pack_id" should be UUID: '.$pack_id);
        }
        $pack = MPack::get($pack_id);
        if (!$pack) {
            throw new ErrorException('"pack_id" should not be existed: '.$pack_id);
        }

        if (!Uuid::isValid($pack->activity_id)) {
            throw new ErrorException('"activity_id" should be UUID: '.$pack->activity_id);
        }
        $activity = MActivity::get($pack->activity_id);
        if (!$activity) {
            throw new ErrorException('"activity_id" should not be existed: '.$pack->activity_id);
        }

        if (!Uuid::isValid($pack->template_id)) {
            throw new ErrorException('"template_id" should not be empty: '.$pack->template_id);
        }
        $template = MCouponTemplate::get($pack->template_id);
        if (!$template) {
            throw new ErrorException('"template_id" should not be existed: '.$pack->template_id);
        }

        $ins = new DbCoupon($owner_id, $activity, $template);
        $ins->dead_time = $pack->dead_time;

        return $ins;
    }

    /**
     * @param DbCoupon $obj
     * @return bool
     * @throws ErrorException
     */
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
     * @param DbCoupon $obj
     * @param array|string $columns
     * @return DbCoupon
     * @throws ErrorException
     */
    public static function put(DbCoupon $obj, $columns = [])
    {
        if (!$obj) {
            throw new ErrorException('"obj" should not be null!');
        }

        $obj->_beforePut()->put($columns);

        return $obj;
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
    public static function list(array $where = null, int $limit = 0, int $page = 0)
    {
        return (new DbCoupons())->select($where, $limit, $page);
    }

    /**
     * @param DbCoupon|string $objOrId
     * @return DbCoupon
     * @throws ErrorException
     */
    protected static function toObj($objOrId): DbCoupon
    {
        if (!$objOrId) {
            throw new ErrorException('"objOrId" should not be null!');
        }

        $obj = null;
        if (gettype($objOrId) === 'string') {
            $obj = self::get($objOrId);
        } elseif ($objOrId instanceof DbCoupon) {
            $obj = $objOrId;
        }

        if (!$obj) {
            throw new ErrorException('"obj" should not be null!');
        }

        return $obj;
    }

    /**
     * @param DbCoupon|string $objOrId
     * @return bool
     * @throws ErrorException
     */
    public static function disable($objOrId): bool
    {
        $obj = self::toObj($objOrId);
        $obj->valid = false;

        return $obj->_beforePut()->put([self::COL_VALID]);
    }

    /**
     * @param DbCoupon|string $objOrId
     * @return bool
     * @throws ErrorException
     */
    public static function use(DbCoupon $objOrId): bool
    {
        $obj = self::toObj($objOrId);

        return $obj->increaseCouponUsed();
    }
}
