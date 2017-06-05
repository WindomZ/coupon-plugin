<?php declare(strict_types=1);

namespace CouponPlugin\Db;

use Ramsey\Uuid\Uuid;

abstract class baseId extends base
{
    const COL_ID = 'id';

    /**
     * @var string
     */
    public $id;

    protected function makeId(): string
    {
        $this->id = Uuid::uuid4()->toString();

        return $this->id;
    }

    /**
     * @return bool
     */
    protected function validId(): bool
    {
        return Uuid::isValid($this->id);
    }

    protected function _insert($datas): bool
    {
        $datas[self::COL_ID] = $this->makeId();

        return parent::_insert($datas);
    }
}
