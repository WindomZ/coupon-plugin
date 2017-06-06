<?php declare(strict_types=1);

namespace CouponPlugin\Db;

use Ramsey\Uuid\Uuid;

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
        return array_merge([self::COL_ID => $this->id], $this->getArray());
    }

    /**
     * @param $data
     * @return object
     */
    abstract protected function getInstance($data);

    /**
     * @param $data
     * @return object
     */
    protected function toInstance($data)
    {
        $this->id = $data[self::COL_ID];

        return $this->getInstance($data);
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
