<?php

declare(strict_types=1);

namespace Tourze\UserServiceContracts\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionNamedType;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Tourze\UserServiceContracts\UserManagerInterface;

/**
 * UserManagerInterface 的测试类
 *
 * @internal
 */
#[CoversClass(UserManagerInterface::class)]
final class UserManagerInterfaceTest extends TestCase
{
    public function testInterfaceExists(): void
    {
        $this->assertTrue(interface_exists(UserManagerInterface::class));
    }

    public function testExtendsUserLoaderInterface(): void
    {
        $reflection = new ReflectionClass(UserManagerInterface::class);
        $this->assertTrue($reflection->implementsInterface(UserLoaderInterface::class));
    }

    public function testHasCreateUserMethod(): void
    {
        $reflection = new ReflectionClass(UserManagerInterface::class);
        $this->assertTrue($reflection->hasMethod('createUser'));

        $method = $reflection->getMethod('createUser');
        $this->assertSame('createUser', $method->getName());
        $this->assertCount(3, $method->getParameters());

        $parameters = $method->getParameters();
        $this->assertSame('userIdentifier', $parameters[0]->getName());
        $paramType = $parameters[0]->getType();
        $this->assertInstanceOf(ReflectionNamedType::class, $paramType);
        $this->assertSame('string', $paramType->getName());
        $this->assertFalse($parameters[0]->allowsNull());

        $this->assertSame('nickName', $parameters[1]->getName());
        $this->assertTrue($parameters[1]->allowsNull());

        $this->assertSame('avatarUrl', $parameters[2]->getName());
        $this->assertTrue($parameters[2]->allowsNull());

        $returnType = $method->getReturnType();
        $this->assertNotNull($returnType);
        $this->assertInstanceOf(ReflectionNamedType::class, $returnType);
        $this->assertSame(UserInterface::class, $returnType->getName());
    }

    public function testHasSaveUserMethod(): void
    {
        $reflection = new ReflectionClass(UserManagerInterface::class);
        $this->assertTrue($reflection->hasMethod('saveUser'));

        $method = $reflection->getMethod('saveUser');
        $this->assertSame('saveUser', $method->getName());
        $this->assertCount(1, $method->getParameters());

        $parameter = $method->getParameters()[0];
        $this->assertSame('user', $parameter->getName());
        $paramType = $parameter->getType();
        $this->assertInstanceOf(ReflectionNamedType::class, $paramType);
        $this->assertSame(UserInterface::class, $paramType->getName());

        $returnType = $method->getReturnType();
        $this->assertNotNull($returnType);
        $this->assertInstanceOf(ReflectionNamedType::class, $returnType);
        $this->assertSame('void', $returnType->getName());
    }

    public function testHasSearchUsersMethod(): void
    {
        $reflection = new ReflectionClass(UserManagerInterface::class);
        $this->assertTrue($reflection->hasMethod('searchUsers'));

        $method = $reflection->getMethod('searchUsers');
        $this->assertSame('searchUsers', $method->getName());
        $this->assertCount(2, $method->getParameters());

        $parameters = $method->getParameters();
        $this->assertSame('query', $parameters[0]->getName());
        $queryParamType = $parameters[0]->getType();
        $this->assertInstanceOf(ReflectionNamedType::class, $queryParamType);
        $this->assertSame('string', $queryParamType->getName());
        $this->assertFalse($parameters[0]->allowsNull());

        $this->assertSame('limit', $parameters[1]->getName());
        $limitParamType = $parameters[1]->getType();
        $this->assertInstanceOf(ReflectionNamedType::class, $limitParamType);
        $this->assertSame('int', $limitParamType->getName());
        $this->assertTrue($parameters[1]->isDefaultValueAvailable());
        $this->assertSame(20, $parameters[1]->getDefaultValue());

        $returnType = $method->getReturnType();
        $this->assertNotNull($returnType);
        $this->assertInstanceOf(ReflectionNamedType::class, $returnType);
        $this->assertSame('array', $returnType->getName());
    }
}
