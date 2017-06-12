<?php declare(strict_types=1);

namespace CouponPlugin\Db;

/**
 * Class DbPacks
 * @package CouponPlugin\Db
 */
class DbPacks extends dbBaseList
{
    /**
     * @return string
     */
    protected function getTableName(): string
    {
        return 'pack';
    }

    /**
     * @param $data
     * @return object
     */
    protected function addInstance($data)
    {
        $ins = new DbPack();
        $ins = $ins->toInstance($data);
        array_push($this->list, $ins);

        return $ins;
    }
}
