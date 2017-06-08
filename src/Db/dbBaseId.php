<?php declare(strict_types=1);

namespace CouponPlugin\Db;

use CouponPlugin\Util\Uuid;

/**
 * Class dbBaseId
 * @package CouponPlugin\Db
 */
abstract class dbBaseId extends dbBase
{
    const COL_ID = 'id';

    /**
     * @var string
     */
    public $id;

    /**
     * @return string
     */
    protected function makeId(): string
    {
        $this->id = Uuid::uuid();

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
     * @param string $Uuid
     * @return bool
     */
    protected function validUuid(string $Uuid): bool
    {
        return Uuid::isValid($Uuid);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [self::COL_ID => $this->id];
    }

    /**
     * @param $data
     * @return object
     */
    public function toInstance($data)
    {
        $this->id = $data[self::COL_ID];

        return $this;
    }

    /**
     * @param array $data
     * @return bool
     */
    protected function _post($data): bool
    {
        if (!$this->validId()) {
            $data[self::COL_ID] = $this->makeId();
        }

        return parent::_post($data);
    }

    /**
     * @return bool
     */
    public function post(): bool
    {
        return $this->_post($this->toArray());
    }

    /**
     * @param array|string $columns
     * @return bool
     */
    public function put($columns = []): bool
    {
        $data = $this->toArray();

        if ($columns !== '*' && gettype($columns) === 'array') {
            $columns = array_diff($columns, [self::COL_ID]);
            $data = array_intersect_key($data, array_flip($columns));
        }

        return $this->_put($data);
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
     * @param string $id
     * @return bool
     */
    public function getById($id): bool
    {
        return $this->_get([self::COL_ID => $id]);
    }
}
