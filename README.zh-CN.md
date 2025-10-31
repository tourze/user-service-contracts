# User Service Contracts

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/user-service-contracts.svg?style=flat-square)](https://packagist.org/packages/tourze/user-service-contracts)
[![PHP Version Require](https://img.shields.io/packagist/php-v/tourze/user-service-contracts?style=flat-square)](https://packagist.org/packages/tourze/user-service-contracts)
[![License](https://img.shields.io/packagist/l/tourze/user-service-contracts?style=flat-square)](https://packagist.org/packages/tourze/user-service-contracts)
[![Build Status](https://img.shields.io/github/actions/workflow/status/tourze/php-monorepo/ci.yml?branch=master&style=flat-square)](https://github.com/tourze/php-monorepo/actions)
[![Coverage Status](https://img.shields.io/coveralls/github/tourze/php-monorepo/master?style=flat-square)](https://coveralls.io/github/tourze/php-monorepo?branch=master)

为 Symfony 应用程序提供用户服务契约和接口的综合 PHP 包。

## 安装

您可以通过 Composer 安装此包：

```bash
composer require tourze/user-service-contracts
```

## 快速开始

此包为 Symfony 应用程序中的用户管理服务提供核心契约。

### 用户计数器接口

```php
<?php

use Tourze\UserServiceContracts\UserCounterInterface;

class UserCounter implements UserCounterInterface
{
    public function countAll(): int
    {
        // 实现计算所有有效用户的逻辑
        return 1000;
    }
}
```

### 用户管理器接口

```php
<?php

use Tourze\UserServiceContracts\UserManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserManager implements UserManagerInterface
{
    public function createUser(string $userIdentifier, ?string $nickName = null, ?string $avatarUrl = null): UserInterface
    {
        // 实现创建新用户的逻辑
        return new User($userIdentifier, $nickName, $avatarUrl);
    }
    
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        // 实现根据标识符加载用户的逻辑
        return $this->findUserByIdentifier($identifier);
    }
}
```

### 常量

```php
<?php

use Tourze\UserServiceContracts\UserServiceConstants;

// 访问预定义常量
$fixturesName = UserServiceConstants::USER_FIXTURES_NAME; // 'users'
$userPrefix = UserServiceConstants::NORMAL_USER_REFERENCE_PREFIX; // 'normal-user-'
```

## 功能特性

- **UserCounterInterface**: 提供用户计数方法
- **UserManagerInterface**: 扩展 Symfony 的 UserLoaderInterface 用于用户管理
- **UserServiceConstants**: 定义用户服务常用常量
- **完整 Symfony 集成**: 与 Symfony Security 组件无缝集成

## 要求

- PHP 8.1 或更高版本
- Symfony 7.3 或更高版本

## 许可证

此包是根据 [MIT 许可证](LICENSE) 授权的开源软件。
