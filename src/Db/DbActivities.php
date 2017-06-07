<?php declare(strict_types=1);

namespace CouponPlugin\Db;

/**
 * Class DbActivities
 * @package CouponPlugin\Db
 */
class DbActivities extends dbBaseList
{
    /**
     * @return string
     */
    protected function getTableName(): string
    {
        return 'activity';
    }

    /**
     * @param $data
     * @return object
     */
    protected function addInstance($data)
    {
        $ins = new DbActivity();
        $ins = $ins->toInstance($data);
        array_push($this->list, $ins);

        return $ins;
    }
}
