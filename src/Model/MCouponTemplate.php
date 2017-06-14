<?php declare(strict_types=1);

namespace CouponPlugin\Model;

use CouponPlugin\Db\DbCouponTemplate;
use CouponPlugin\Db\DbCouponTemplates;
use CouponPlugin\ErrorException;

/**
 * Class MCouponTemplate
 * @package CouponPlugin\Model
 */
class MCouponTemplate extends mBase
{
    const COL_ID = DbCouponTemplate::COL_ID;
    const COL_POST_TIME = DbCouponTemplate::COL_POST_TIME;
    const COL_PUT_TIME = DbCouponTemplate::COL_PUT_TIME;
    const COL_CLASS = DbCouponTemplate::COL_CLASS;
    const COL_KIND = DbCouponTemplate::COL_KIND;
    const COL_PRODUCT_ID = DbCouponTemplate::COL_PRODUCT_ID;
    const COL_NAME = DbCouponTemplate::COL_NAME;
    const COL_DESC = DbCouponTemplate::COL_DESC;
    const COL_MIN_AMOUNT = DbCouponTemplate::COL_MIN_AMOUNT;
    const COL_OFFER_AMOUNT = DbCouponTemplate::COL_OFFER_AMOUNT;
    const COL_VALID = DbCouponTemplate::COL_VALID;

    private function __construct()
    {
    }

    /**
     * @param string $name
     * @param string $desc
     * @param int $min_amount
     * @param int $offer_amount
     * @return DbCouponTemplate
     * @throws ErrorException
     */
    public static function object(
        string $name,
        string $desc = '',
        $min_amount = 0,
        $offer_amount = 0
    ): DbCouponTemplate {
        if (empty($name)) {
            throw new ErrorException('"name" should not be empty: '.$name);
        }
        if ($min_amount < 0) {
            $min_amount = 0;
        }
        if ($offer_amount < 0) {
            throw new ErrorException('"offer_amount" should be positive integer: '.$offer_amount);
        }

        return new DbCouponTemplate($name, $desc, $min_amount, $offer_amount);
    }

    /**
     * @param DbCouponTemplate $obj
     * @return bool
     * @throws ErrorException
     */
    public static function post(DbCouponTemplate $obj): bool
    {
        if (!$obj) {
            throw new ErrorException('"obj" should not be null!');
        }

        return $obj->_beforePost()->post();
    }

    /**
     * @param DbCouponTemplate $obj
     * @param array|string $columns
     * @return DbCouponTemplate
     * @throws ErrorException
     */
    public static function put(DbCouponTemplate $obj, $columns = [])
    {
        if (!$obj) {
            throw new ErrorException('"obj" should not be null!');
        }

        $obj->_beforePut()->put($columns);

        return $obj;
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

    /**
     * @param array|null $where
     * @param int $limit
     * @param int $page
     * @return array|null
     */
    public static function list(array $where = null, int $limit = 0, int $page = 0)
    {
        return (new DbCouponTemplates())->select($where, $limit, $page);
    }

    /**
     * @param DbCouponTemplate|string $objOrId
     * @return DbCouponTemplate
     * @throws ErrorException
     */
    protected static function toObj($objOrId): DbCouponTemplate
    {
        if (!$objOrId) {
            throw new ErrorException('"objOrId" should not be null!');
        }

        $obj = null;
        if (gettype($objOrId) === 'string') {
            $obj = self::get($objOrId);
        } elseif ($objOrId instanceof DbCouponTemplate) {
            $obj = $objOrId;
        }

        if (!$obj) {
            throw new ErrorException('"obj" should not be null!');
        }

        return $obj;
    }

    /**
     * @param DbCouponTemplate|string $objOrId
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
