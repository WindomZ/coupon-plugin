<?php declare(strict_types=1);

namespace CouponPlugin\Db;

use Ramsey\Uuid\Uuid;

abstract class dbBaseId extends dbBase
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
        if (!$this->validId()) {
            $datas[self::COL_ID] = $this->makeId();
        }

        return parent::_insert($datas);
    }

    /**
     * @param $id
     * @return bool
     */
    abstract public function getById($id): bool;

    /**
     * @param string $id
     * @return bool
     */
    public function _getById($id): bool
    {
        return $this->_get([self::COL_ID => $id]);
    }
}
