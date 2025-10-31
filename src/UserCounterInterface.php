<?php

declare(strict_types=1);

namespace Tourze\UserServiceContracts;

interface UserCounterInterface
{
    /**
     * 查找有效用户数
     */
    public function countAll(): int;
}
