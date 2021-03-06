<?php declare(strict_types=1);

namespace CouponPlugin\Model;

/**
 * Class mBase
 * @package CouponPlugin\Model
 */
abstract class mBase
{
    private function __construct()
    {
    }

    /**
     * @param mixed $obj
     * @return mixed
     */
    public static function toJSON($obj)
    {
        return json_decode(json_encode($obj), true);
    }

    const WHERE_EQ = 0;
    const WHERE_NEQ = 1;
    const WHERE_GT = 2;
    const WHERE_GTE = 3;
    const WHERE_LT = 4;
    const WHERE_LTE = 5;
    const WHERE_BT = 6;
    const WHERE_NBT = 7;

    /**
     * @param int $type
     * @param string $key
     * @return string
     */
    public static function where(int $type, string $key): string
    {
        switch ($type) {
            case self::WHERE_NEQ:
                $key .= '[!]';
                break;
            case self::WHERE_GT:
                $key .= '[>]';
                break;
            case self::WHERE_GTE:
                $key .= '[>=]';
                break;
            case self::WHERE_LT:
                $key .= '[<]';
                break;
            case self::WHERE_LTE:
                $key .= '[<=]';
                break;
            case self::WHERE_BT:
                $key .= '[<>]';
                break;
            case self::WHERE_NBT:
                $key .= '[><]';
                break;
        }

        return $key;
    }
}
