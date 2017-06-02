<?php declare(strict_types=1);

namespace CouponPlugin;

require 'vendor/autoload.php';

use Medoo\Medoo;

class Database
{
    /**
     * @var Medoo
     */
    protected $database;

    /**
     * @param  Config $config
     */
    public function __construct($config)
    {
        $this->database = new Medoo(
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
