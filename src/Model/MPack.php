<?php declare(strict_types=1);

namespace CouponPlugin\Model;

use CouponPlugin\Db\DbPack;
use CouponPlugin\Db\DbPacks;
use CouponPlugin\ErrorException;
use CouponPlugin\Util\Date;
use CouponPlugin\Util\Uuid;

/**
 * Class MPack
 * @package CouponPlugin\Model
 */
class MPack extends mBase
{
    const COL_ID = DbPack::COL_ID;
    const COL_POST_TIME = DbPack::COL_POST_TIME;
    const COL_PUT_TIME = DbPack::COL_PUT_TIME;
    const COL_ACTIVITY_ID = DbPack::COL_ACTIVITY_ID;
    const COL_TEMPLATE_ID = DbPack::COL_TEMPLATE_ID;

    const COL_NAME = DbPack::COL_NAME;
    const COL_LEVEL = DbPack::COL_LEVEL;
    const COL_VALID = DbPack::COL_VALID;
    const COL_DEAD_TIME = DbPack::COL_DEAD_TIME;

    private function __construct()
    {
    }

    /**
     * @param string $name
     * @param string $activity_id
     * @param string $template_id
     * @return DbPack
     * @throws ErrorException
     */
    public static function object(
        string $name = '',
        string $activity_id,
        string $template_id
    ): DbPack {
        if (empty($name)) {
            throw new ErrorException('"name" should not be empty: '.$name);
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

        $ins = new DbPack($name, $activity, $template);

        $ins->level = $activity->level;
        $ins->valid = $activity->valid && $template->valid;
        $ins->dead_time = $activity->dead_time;
        if (Date::after($ins->dead_time, $template->dead_time)) {
            $ins->dead_time = $template->dead_time;
        }

        return $ins;
    }

    /**
     * @param DbPack $obj
     * @return bool
     * @throws ErrorException
     */
    public static function post(DbPack $obj): bool
    {
        if (!$obj) {
            throw new ErrorException('"obj" should not be null!');
        }

        return $obj->_beforePost()->post();
    }

    /**
     * @param DbPack $obj
     * @param array|string $columns
     * @return DbPack
     * @throws ErrorException
     */
    public static function put(DbPack $obj, $columns = [])
    {
        if (!$obj) {
            throw new ErrorException('"obj" should not be null!');
        }

        $obj->_beforePut()->put($columns);

        return $obj;
    }

    /**
     * @param string $id
     * @return DbPack|null
     */
    public static function get(string $id)
    {
        $ins = new DbPack();
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
        return (new DbPacks())->select($where, $limit, $page);
    }

    /**
     * @param DbPack|string $objOrId
     * @return DbPack
     * @throws ErrorException
     */
    protected static function toObj($objOrId): DbPack
    {
        if (!$objOrId) {
            throw new ErrorException('"objOrId" should not be null!');
        }

        $obj = null;
        if (gettype($objOrId) === 'string') {
            $obj = self::get($objOrId);
        } elseif ($objOrId instanceof DbPack) {
            $obj = $objOrId;
        }

        if (!$obj) {
            throw new ErrorException('"obj" should not be null!');
        }

        return $obj;
    }

    /**
     * @param DbPack|string $objOrId
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
     * @param DbPack|string $objOrId
     * @param string $owner_id
     * @return \CouponPlugin\Db\DbCoupon
     * @throws ErrorException
     */
    public static function objectCoupon($objOrId, string $owner_id)
    {
        $obj = self::toObj($objOrId);

        $ins = MCoupon::object($owner_id, $obj->activity_id, $obj->template_id);
        $ins->dead_time = $obj->dead_time;

        return $ins;
    }
}
