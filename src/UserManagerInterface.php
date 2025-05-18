<?php

namespace Tourze\UserServiceContracts;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

interface UserManagerInterface extends UserLoaderInterface
{
    /**
     * 创建用户
     */
    public function createUser(string $userIdentifier, ?string $nickName = null, ?string $avatarUrl = null);
}
