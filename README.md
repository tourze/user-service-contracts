# User Service Contracts

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/user-service-contracts.svg?style=flat-square)](https://packagist.org/packages/tourze/user-service-contracts)
[![PHP Version Require](https://img.shields.io/packagist/php-v/tourze/user-service-contracts?style=flat-square)](https://packagist.org/packages/tourze/user-service-contracts)
[![License](https://img.shields.io/packagist/l/tourze/user-service-contracts?style=flat-square)](https://packagist.org/packages/tourze/user-service-contracts)
[![Build Status](https://img.shields.io/github/actions/workflow/status/tourze/php-monorepo/ci.yml?branch=master&style=flat-square)](https://github.com/tourze/php-monorepo/actions)
[![Coverage Status](https://img.shields.io/coveralls/github/tourze/php-monorepo/master?style=flat-square)](https://coveralls.io/github/tourze/php-monorepo?branch=master)

A comprehensive PHP package providing user service contracts and interfaces for Symfony applications.

## Installation

You can install this package via Composer:

```bash
composer require tourze/user-service-contracts
```

## Quick Start

This package provides essential contracts for user management services in Symfony applications.

### User Counter Interface

```php
<?php

use Tourze\UserServiceContracts\UserCounterInterface;

class UserCounter implements UserCounterInterface
{
    public function countAll(): int
    {
        // Implementation for counting all valid users
        return 1000;
    }
}
```

### User Manager Interface

```php
<?php

use Tourze\UserServiceContracts\UserManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserManager implements UserManagerInterface
{
    public function createUser(string $userIdentifier, ?string $nickName = null, ?string $avatarUrl = null): UserInterface
    {
        // Implementation for creating a new user
        return new User($userIdentifier, $nickName, $avatarUrl);
    }
    
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        // Implementation for loading user by identifier
        return $this->findUserByIdentifier($identifier);
    }
}
```

### Constants

```php
<?php

use Tourze\UserServiceContracts\UserServiceConstants;

// Access predefined constants
$fixturesName = UserServiceConstants::USER_FIXTURES_NAME; // 'users'
$userPrefix = UserServiceConstants::NORMAL_USER_REFERENCE_PREFIX; // 'normal-user-'
```

## Features

- **UserCounterInterface**: Provides methods for counting users
- **UserManagerInterface**: Extends Symfony's UserLoaderInterface for user management
- **UserServiceConstants**: Defines commonly used constants for user services
- **Full Symfony Integration**: Seamlessly integrates with Symfony Security component

## Requirements

- PHP 8.1 or higher
- Symfony 7.3 or higher

## License

This package is open-source software licensed under the [MIT license](LICENSE).