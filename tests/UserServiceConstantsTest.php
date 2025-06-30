<?php

declare(strict_types=1);

namespace Tourze\UserServiceContracts\Tests;

use PHPUnit\Framework\TestCase;
use Tourze\UserServiceContracts\UserServiceConstants;

/**
 * UserServiceConstants 的测试类
 */
class UserServiceConstantsTest extends TestCase
{
    public function testClassExists(): void
    {
        $this->assertTrue(class_exists(UserServiceConstants::class));
    }

    public function testUserFixturesNameConstant(): void
    {
        $this->assertSame('users', UserServiceConstants::USER_FIXTURES_NAME);
    }
}