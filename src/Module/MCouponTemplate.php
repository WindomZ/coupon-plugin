<?php declare(strict_types=1);

namespace CouponPlugin\Module;

use CouponPlugin\Db\DbCouponTemplate;
use CouponPlugin\ErrorException;
use CouponPlugin\Util\Date;

/**
 * Class MCouponTest
 * @package CouponPlugin\Module
 */
class MCouponTemplate extends mBase
{
    private function __construct()
    {
    }

    /**
     * @param string $name
     * @param string $desc
     * @param int $min_amount
     * @param int $offer_amount
     * @param int $second
     * @return bool
     * @throws ErrorException
     */
    public static function post(
        string $name,
        string $desc = '',
        $min_amount = 0,
        $offer_amount = 0,
        $second = 86400// 1 day
    ): bool {
        if (empty($name)) {
            throw new ErrorException('"name" should not be empty: '.$name);
        }
        if ($min_amount < 0) {
            $min_amount = 0;
        }
        if ($offer_amount <= 0) {
            throw new ErrorException('"offer_amount" should be positive integer: '.$offer_amount);
        }

        $ins = new DbCouponTemplate($name, $desc, $min_amount, $offer_amount);
        $ins->dead_time = Date::get_next_time($second);

        return $ins->post();
    }

    /**
     * @param string $id
     * @param array $columns
     * @param callback $callback
     * @return DbCouponTemplate|null
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
     * @return DbCouponTemplate|null
     */
    public static function get(string $id)
    {
        $ins = new DbCouponTemplate();
        if (!$ins->getById($id)) {
            return null;
        }

        return $ins;
    }

    public static function list()
    {
    }
}
