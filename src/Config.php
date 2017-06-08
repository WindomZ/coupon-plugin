<?php declare(strict_types=1);

namespace CouponPlugin;

/**
 * Class Config
 * @package CouponPlugin
 */
class Config extends \Noodlehaus\Config
{
    /**
     * Config constructor.
     * @param array|string $path
     */
    public function __construct($path)
    {
        parent::__construct($path);
    }

    /**
     * @return array
     */
    protected function getDefaults()
    {
        return [
            'database' => [
                'host' => '127.0.0.1',
                'port' => 3306,
                'type' => 'mysql',
                'name' => 'testdb',
                'username' => 'root',
                'password' => 'root',
                'logging' => false,
                'prefix' => 'cp_',
            ],
        ];
    }
}
