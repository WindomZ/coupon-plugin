<?php declare(strict_types=1);

namespace CouponPlugin;

use Medoo\Medoo;

/**
 * Class Database
 * @package CouponPlugin
 */
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
                'port' => $config->get('database.port'),
                'charset' => $config->get('database.charset'),
                'logging' => $config->get('database.logging'),
                'prefix' => $config->get('database.prefix'),
                'option' => $config->get('database.option'),
                'command' => $config->get('database.command'),
            ]
        );
    }
}
