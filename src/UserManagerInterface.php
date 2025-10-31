<?php

declare(strict_types=1);

namespace Tourze\UserServiceContracts;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface UserManagerInterface extends UserLoaderInterface
{
    /**
     * 创建用户
     */
    public function createUser(string $userIdentifier, ?string $nickName = null, ?string $avatarUrl = null): UserInterface;

    /**
     * 保存用户
     */
    public function saveUser(UserInterface $user): void;

    /**
     * 搜索用户（用于自动完成等场景）
     *
     * @return array<array{id: mixed, text: string}>
     */
    public function searchUsers(string $query, int $limit = 20): array;
}
