<?php declare(strict_types=1);

namespace CouponPlugin\Test\Util;

use CouponPlugin\Util\Uuid;
use PHPUnit\Framework\TestCase;

/**
 * Class UuidTest
 * @package CouponPlugin\Test\Util
 */
class UuidTest extends TestCase
{
    /**
     *
     */
    public function testUuid()
    {
        $this->assertTrue(Uuid::isValid(Uuid::uuid()));
    }
}
