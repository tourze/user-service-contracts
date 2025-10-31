<?php

declare(strict_types=1);

namespace Tourze\UserServiceContracts\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\UserServiceContracts\UserServiceConstants;

/**
 * UserServiceConstants 的测试类
 *
 * @internal
 */
#[CoversClass(UserServiceConstants::class)]
final class UserServiceConstantsTest extends TestCase
{
    public function testAdminUserReferenceConstant(): void
    {
        $this->assertSame('admin-user', UserServiceConstants::ADMIN_USER_REFERENCE);
    }

    public function testModeratorUserReferenceConstant(): void
    {
        $this->assertSame('moderator-user', UserServiceConstants::MODERATOR_USER_REFERENCE);
    }

    public function testUserFixturesNameConstant(): void
    {
        $this->assertSame('users', UserServiceConstants::USER_FIXTURES_NAME);
    }

    public function testNormalUserReferencePrefixConstant(): void
    {
        $this->assertSame('normal-user-', UserServiceConstants::NORMAL_USER_REFERENCE_PREFIX);
    }
}
