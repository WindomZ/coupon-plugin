<?php declare(strict_types=1);

namespace CouponPlugin;

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
    public function getDatabase(): Database
    {
        return $this->database;
    }

    public function __construct($configPath)
    {
        $this->config = new Config($configPath);
        $this->database = new Database($this->config);
    }
}
