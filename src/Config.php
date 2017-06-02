<?php declare(strict_types=1);

namespace CouponPlugin;

class Config extends \Noodlehaus\Config
{
    public function __construct($path)
    {
        parent::__construct($path);
    }

    protected function getDefaults()
    {
        return array(
            'host' => '127.0.0.1',
            'port' => 80,
            'database' => array(
                'host' => '127.0.0.1',
                'port' => 3306,
                'type' => 'mysql',
                'name' => 'name',
                'username' => 'root',
                'password' => 'root',
            ),
        );
    }
}
