<?php declare(strict_types=1);

namespace CouponPlugin;

/**
 * Class Coupon
 * @package CouponPlugin
 */
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

    /**
     * @var string
     */
    public static $configPath = './config.yml';

    /**
     * @var Coupon
     */
    private static $_instance;

    private function __clone()
    {
    }

    /**
     * @return Coupon
     */
    public static function getInstance(): Coupon
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new Coupon();
        }

        return self::$_instance;
    }

    /**
     * Coupon constructor.
     */
    private function __construct()
    {
        $this->config = new Config(self::$configPath);
        $this->database = new Database($this->config);

        self::$_instance = $this;
    }
}
