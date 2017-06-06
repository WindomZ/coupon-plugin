<?php declare(strict_types=1);

namespace CouponPlugin;

use Noodlehaus\ErrorException;

class Coupon
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @var Database
     */
    protected $database;

    /**
     * @return Database
     */
    public function getDb(): Database
    {
        return $this->database;
    }

    public static $configPath = './config.yml';

    private static $_instance;

    private function __clone()
    {
    }

    public static function getInstance(): Coupon
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new Coupon();
        }

        return self::$_instance;
    }

    private function __construct()
    {
        $this->config = new Config(self::$configPath);
        $this->database = new Database($this->config);

        self::$_instance = $this;
    }
}
