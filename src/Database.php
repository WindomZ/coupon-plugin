<?php declare(strict_types=1);

namespace CouponPlugin;

require 'vendor/autoload.php';

use Medoo\Medoo;

class Database extends Medoo
{

    /**
     * @param  Config $config
     */
    public function __construct($config)
    {
        parent::__construct(
            [
                'database_type' => $config->get('database.type'),
                'database_name' => $config->get('database.name'),
                'server' => $config->get('database.host'),
                'username' => $config->get('database.username'),
                'password' => $config->get('database.password'),
            ]
        );
    }
}
