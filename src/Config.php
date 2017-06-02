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
            'host' => 'localhost',
            'port' => 80,
            'database' => array(
                'host' => 'localhost',
                'port' => 3306,
                'user' => 'root',
                'secret' => 'root',
            ),
        );
    }
}
