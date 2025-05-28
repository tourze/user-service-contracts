<?php

declare(strict_types=1);

namespace Tourze\UserServiceContracts\Tests;

use PHPUnit\Framework\TestCase;
use Tourze\UserServiceContracts\UserCounterInterface;

/**
 * UserCounterInterface 接口的 contract 测试
 */
class UserCounterInterfaceTest extends TestCase
{
    public function testInterfaceExists(): void
    {
        $this->assertTrue(interface_exists(UserCounterInterface::class));
    }

    public function testCountAllMethodSignature(): void
    {
        $ref = new \ReflectionClass(UserCounterInterface::class);
        $this->assertTrue($ref->hasMethod('countAll'));
        
        $method = $ref->getMethod('countAll');
        $this->assertTrue($method->hasReturnType());
        $this->assertSame('int', $method->getReturnType()->getName());
        $this->assertCount(0, $method->getParameters());
    }

    public function testCountAllMethodDocumentation(): void
    {
        $ref = new \ReflectionClass(UserCounterInterface::class);
        $method = $ref->getMethod('countAll');
        $docComment = $method->getDocComment();
        
        $this->assertNotFalse($docComment);
        $this->assertStringContainsString('查找有效用户数', $docComment);
    }

    /**
     * 用于 contract 测试的 mock 实现
     */
    public function testMockImplementation(): void
    {
        $mock = new class implements UserCounterInterface {
            public function countAll(): int
            {
                return 0;
            }
        };
        
        $this->assertInstanceOf(UserCounterInterface::class, $mock);
        $this->assertIsInt($mock->countAll());
    }

    /**
     * 测试 mock 实现的边界情况
     */
    public function testMockImplementationBoundaryValues(): void
    {
        // 测试返回 0 的情况
        $mockZero = new class implements UserCounterInterface {
            public function countAll(): int
            {
                return 0;
            }
        };
        $this->assertSame(0, $mockZero->countAll());

        // 测试返回正数的情况
        $mockPositive = new class implements UserCounterInterface {
            public function countAll(): int
            {
                return 100;
            }
        };
        $this->assertSame(100, $mockPositive->countAll());

        // 测试返回大数的情况
        $mockLarge = new class implements UserCounterInterface {
            public function countAll(): int
            {
                return PHP_INT_MAX;
            }
        };
        $this->assertSame(PHP_INT_MAX, $mockLarge->countAll());
    }
} 