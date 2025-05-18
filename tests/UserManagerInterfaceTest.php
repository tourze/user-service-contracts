<?php

declare(strict_types=1);

namespace Tourze\UserServiceContracts\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Tourze\UserServiceContracts\UserManagerInterface;

/**
 * UserManagerInterface 接口的 contract 测试
 */
class UserManagerInterfaceTest extends TestCase
{
    public function testInterfaceExists(): void
    {
        $this->assertTrue(interface_exists(UserManagerInterface::class));
    }

    public function testExtendsUserLoaderInterface(): void
    {
        $this->assertTrue(is_subclass_of(UserManagerInterface::class, UserLoaderInterface::class));
    }

    public function testCreateUserSignature(): void
    {
        $ref = new \ReflectionClass(UserManagerInterface::class);
        $this->assertTrue($ref->hasMethod('createUser'));
        $method = $ref->getMethod('createUser');
        $params = $method->getParameters();
        $this->assertSame('userIdentifier', $params[0]->getName());
        $this->assertSame('nickName', $params[1]->getName());
        $this->assertSame('avatarUrl', $params[2]->getName());
        $this->assertTrue($params[0]->hasType() && $params[0]->getType()->getName() === 'string');
        $this->assertTrue($params[1]->hasType() && $params[1]->getType()->allowsNull());
        $this->assertTrue($params[2]->hasType() && $params[2]->getType()->allowsNull());
    }

    /**
     * 用于 contract 测试的 mock 实现
     */
    public function testMockImplementation(): void
    {
        $mock = new class implements UserManagerInterface {
            public function loadUserByIdentifier(string $identifier): ?\Symfony\Component\Security\Core\User\UserInterface { return null; }
            public function createUser(string $userIdentifier, ?string $nickName = null, ?string $avatarUrl = null) {}
        };
        $this->assertInstanceOf(UserManagerInterface::class, $mock);
    }
}
