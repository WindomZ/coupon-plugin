<?php declare(strict_types=1);

namespace CouponPlugin\Module;

use CouponPlugin\Db\DbCoupon;
use CouponPlugin\Db\DbCoupons;
use CouponPlugin\ErrorException;
use CouponPlugin\Util\Date;

/**
 * Class MCoupon
 * @package CouponPlugin\Module
 */
class MCoupon extends mBase
{
    private function __construct()
    {
    }

    /**
     * @param string $owner_id
     * @param string $activity_id
     * @param string $template_id
     * @param int $second
     * @return bool
     * @throws ErrorException
     */
    public static function post(
        string $owner_id,
        string $activity_id,
        string $template_id,
        $second = 0
    ): bool {
        if (empty($owner_id)) {
            throw new ErrorException('"owner_id" should not be empty: '.$owner_id);
        }

        if (empty($activity_id)) {
            throw new ErrorException('"activity_id" should not be empty: '.$activity_id);
        }

        if (empty($template_id)) {
            throw new ErrorException('"template_id" should not be empty: '.$template_id);
        }
        $template = MCouponTemplate::get($template_id);
        if (!$template) {
            throw new ErrorException('"template_id" should not be existed: '.$template_id);
        }

        $ins = new DbCoupon($template->id, $template->id, $template);
        if ($second > 0) {
            $ins->dead_time = Date::get_next_time($second);
        }

        return $ins->post();
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
        if (empty($id)) {
            throw new ErrorException('"id" should not be empty: '.$id);
        }

        $ins = self::get($id);
        if (!$ins) {
            throw new ErrorException('Not found id: '.$id);
        }

        if ($callback) {
            $callback($ins);
        }

        $ins->put($columns);

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
