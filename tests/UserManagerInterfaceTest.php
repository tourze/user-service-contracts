<?php

declare(strict_types=1);

namespace Tourze\UserServiceContracts\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
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
        $ref = new \ReflectionClass(UserManagerInterface::class);
        $interfaces = $ref->getInterfaceNames();
        $this->assertContains(UserLoaderInterface::class, $interfaces);
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
        $this->assertTrue($params[0]->hasType());
        $type0 = $params[0]->getType();
        $this->assertNotNull($type0);
        $this->assertSame('string', $type0->__toString());
        
        $this->assertTrue($params[1]->hasType());
        $type1 = $params[1]->getType();
        $this->assertNotNull($type1);
        $this->assertTrue($type1->allowsNull());
        
        $this->assertTrue($params[2]->hasType());
        $type2 = $params[2]->getType();
        $this->assertNotNull($type2);
        $this->assertTrue($type2->allowsNull());
        
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
        $this->assertTrue($params[0]->hasType());
        $paramType = $params[0]->getType();
        $this->assertNotNull($paramType);
        $this->assertSame('string', $paramType->__toString());
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
            
            public function createUser(string $userIdentifier, ?string $nickName = null, ?string $avatarUrl = null): \Symfony\Component\Security\Core\User\UserInterface {
                // Mock implementation - create a minimal UserInterface implementation
                return new class($userIdentifier) implements \Symfony\Component\Security\Core\User\UserInterface {
                    private string $userIdentifier;
                    
                    public function __construct(string $userIdentifier) {
                        $this->userIdentifier = $userIdentifier;
                    }
                    
                    public function getUserIdentifier(): string {
                        return $this->userIdentifier;
                    }
                    
                    public function getRoles(): array {
                        return [];
                    }
                    
                    public function eraseCredentials(): void {
                        // No-op
                    }
                };
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
            
            public function createUser(string $userIdentifier, ?string $nickName = null, ?string $avatarUrl = null): \Symfony\Component\Security\Core\User\UserInterface {
                return new class($userIdentifier, $nickName, $avatarUrl) implements \Symfony\Component\Security\Core\User\UserInterface {
                    private string $userIdentifier;
                    private ?string $nickName;
                    private ?string $avatarUrl; 
                    
                    public function __construct(string $userIdentifier, ?string $nickName, ?string $avatarUrl) {
                        $this->userIdentifier = $userIdentifier;
                        $this->nickName = $nickName;
                        $this->avatarUrl = $avatarUrl;
                    }
                    
                    public function getUserIdentifier(): string {
                        return $this->userIdentifier;
                    }
                    
                    public function getRoles(): array {
                        return [];
                    }
                    
                    public function eraseCredentials(): void {
                        // No-op
                    }
                    
                    public function getNickName(): ?string {
                        return $this->nickName;
                    }
                    
                    public function getAvatarUrl(): ?string {
                        return $this->avatarUrl;
                    }
                };
            }
        };
        
        // 测试 createUser 方法的不同调用方式
        $result1 = $mock->createUser('test@example.com');
        $this->assertInstanceOf(\Symfony\Component\Security\Core\User\UserInterface::class, $result1);
        $this->assertSame('test@example.com', $result1->getUserIdentifier());
        
        $result2 = $mock->createUser('test@example.com', 'Test User');
        $this->assertInstanceOf(\Symfony\Component\Security\Core\User\UserInterface::class, $result2);
        $this->assertSame('test@example.com', $result2->getUserIdentifier());
        
        $result3 = $mock->createUser('test@example.com', 'Test User', 'https://example.com/avatar.jpg');
        $this->assertInstanceOf(\Symfony\Component\Security\Core\User\UserInterface::class, $result3);
        $this->assertSame('test@example.com', $result3->getUserIdentifier());
        
        // 测试 loadUserByIdentifier 方法
        $user = $mock->loadUserByIdentifier('test@example.com');
        $this->assertNull($user);
    }
}
