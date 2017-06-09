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

    protected function getDefault($key)
    {
        $default = null;
        $defaults = $this->getDefaults();
        if (array_key_exists($key, $defaults)) {
            $default = $defaults[$key];
        } else {
            $default = $defaults;
            $segments = explode('.', $key);
            foreach ($segments as $segment) {
                if (array_key_exists($segment, $default)) {
                    $default = $default[$segment];
                    continue;
                } else {
                    $default = null;
                    break;
                }
            }
        }

        return $default;
    }

    public function get($key, $default = null)
    {
        if (!isset($default)) {
            $default = $this->getDefault($key);
        }

        return parent::get($key, $default);
    }
}
