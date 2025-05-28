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
        
        // 验证参数数量
        $this->assertCount(3, $params);
        
        // 验证参数名称
        $this->assertSame('userIdentifier', $params[0]->getName());
        $this->assertSame('nickName', $params[1]->getName());
        $this->assertSame('avatarUrl', $params[2]->getName());
        
        // 验证参数类型
        $this->assertTrue($params[0]->hasType() && $params[0]->getType()->getName() === 'string');
        $this->assertTrue($params[1]->hasType() && $params[1]->getType()->allowsNull());
        $this->assertTrue($params[2]->hasType() && $params[2]->getType()->allowsNull());
        
        // 验证可选参数的默认值
        $this->assertTrue($params[1]->isDefaultValueAvailable());
        $this->assertNull($params[1]->getDefaultValue());
        $this->assertTrue($params[2]->isDefaultValueAvailable());
        $this->assertNull($params[2]->getDefaultValue());
    }

    public function testCreateUserMethodDocumentation(): void
    {
        $ref = new \ReflectionClass(UserManagerInterface::class);
        $method = $ref->getMethod('createUser');
        $docComment = $method->getDocComment();
        
        $this->assertNotFalse($docComment);
        $this->assertStringContainsString('创建用户', $docComment);
    }

    public function testInheritedLoadUserByIdentifierMethod(): void
    {
        $ref = new \ReflectionClass(UserManagerInterface::class);
        
        // 验证继承的方法存在
        $this->assertTrue($ref->hasMethod('loadUserByIdentifier'));
        
        $method = $ref->getMethod('loadUserByIdentifier');
        $params = $method->getParameters();
        
        // 验证继承方法的参数
        $this->assertCount(1, $params);
        $this->assertSame('identifier', $params[0]->getName());
        $this->assertTrue($params[0]->hasType() && $params[0]->getType()->getName() === 'string');
    }

    /**
     * 用于 contract 测试的 mock 实现
     */
    public function testMockImplementation(): void
    {
        $mock = new class implements UserManagerInterface {
            public function loadUserByIdentifier(string $identifier): ?\Symfony\Component\Security\Core\User\UserInterface { 
                return null; 
            }
            
            public function createUser(string $userIdentifier, ?string $nickName = null, ?string $avatarUrl = null) {
                // Mock implementation
            }
        };
        
        $this->assertInstanceOf(UserManagerInterface::class, $mock);
        $this->assertInstanceOf(UserLoaderInterface::class, $mock);
    }

    /**
     * 测试 mock 实现的方法调用
     */
    public function testMockImplementationMethodCalls(): void
    {
        $mock = new class implements UserManagerInterface {
            public function loadUserByIdentifier(string $identifier): ?\Symfony\Component\Security\Core\User\UserInterface { 
                return null; 
            }
            
            public function createUser(string $userIdentifier, ?string $nickName = null, ?string $avatarUrl = null) {
                return ['userIdentifier' => $userIdentifier, 'nickName' => $nickName, 'avatarUrl' => $avatarUrl];
            }
        };
        
        // 测试 createUser 方法的不同调用方式
        $result1 = $mock->createUser('test@example.com');
        $this->assertIsArray($result1);
        
        $result2 = $mock->createUser('test@example.com', 'Test User');
        $this->assertIsArray($result2);
        
        $result3 = $mock->createUser('test@example.com', 'Test User', 'https://example.com/avatar.jpg');
        $this->assertIsArray($result3);
        
        // 测试 loadUserByIdentifier 方法
        $user = $mock->loadUserByIdentifier('test@example.com');
        $this->assertNull($user);
    }
}
