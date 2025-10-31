<?php

declare(strict_types=1);

namespace Tourze\UserServiceContracts\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionNamedType;
use Tourze\UserServiceContracts\UserCounterInterface;

/**
 * UserCounterInterface 的测试类
 *
 * @internal
 */
#[CoversClass(UserCounterInterface::class)]
final class UserCounterInterfaceTest extends TestCase
{
    public function testInterfaceExists(): void
    {
        $this->assertTrue(interface_exists(UserCounterInterface::class));
    }

    public function testHasCountAllMethod(): void
    {
        $reflection = new ReflectionClass(UserCounterInterface::class);
        $this->assertTrue($reflection->hasMethod('countAll'));

        $method = $reflection->getMethod('countAll');
        $this->assertSame('countAll', $method->getName());
        $this->assertCount(0, $method->getParameters());

        $returnType = $method->getReturnType();
        $this->assertNotNull($returnType);
        $this->assertInstanceOf(ReflectionNamedType::class, $returnType);
        $this->assertSame('int', $returnType->getName());
    }
}
