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

    /**
     * @return array
     */
    abstract protected function getArray(): array;

    /**
     * @return array
     */
    protected function toArray(): array
    {
        return array();
    }

    /**
     * @param $data
     * @return bool
     */
    abstract protected function getInstance($data): bool;

    /**
     * @param $data
     * @return bool
     */
    protected function toInstance($data): bool
    {
        $this->id = $data[self::COL_ID];

        return $this->getInstance($data);
    }

    /**
     * @param array $data
     * @return bool
     */
    protected function _insert($data): bool
    {
        if (!$this->validId()) {
            $data[self::COL_ID] = $this->makeId();
        }

        return parent::_insert($data);
    }

    /**
     * @return bool
     */
    public function insert(): bool
    {
        return parent::_insert($this->getArray());
    }

    /**
     * @param array $where
     * @return bool
     */
    public function get($where): bool
    {
        return $this->_get($where);
    }

    /**
     * @param $id
     * @return bool
     */
    public function getById($id): bool
    {
        return $this->_getById($id);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function _getById($id): bool
    {
        return $this->_get([self::COL_ID => $id]);
    }
}
