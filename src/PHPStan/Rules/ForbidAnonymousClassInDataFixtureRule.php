<?php

declare(strict_types=1);

namespace Tourze\UserServiceContracts\PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * 禁止在 DataFixtures 中使用匿名类实现 UserInterface，强制使用 UserManagerInterface 依赖注入
 *
 * @implements Rule<New_>
 */
class ForbidAnonymousClassInDataFixtureRule implements Rule
{
    public function getNodeType(): string
    {
        return New_::class;
    }

    /**
     * @param New_ $node
     * @return array<RuleError>
     */
    public function processNode(Node $node, Scope $scope): array
    {
        // 只检查匿名类
        if (!$node->class instanceof Class_) {
            return [];
        }

        // 只检查 DataFixtures 文件
        $fileName = $scope->getFile();
        if (!str_contains($fileName, '/DataFixtures/') && !str_contains($fileName, '\DataFixtures\\')) {
            return [];
        }

        // 检查是否在 Fixture 类中
        $classReflection = $scope->getClassReflection();
        if (!$classReflection || !$classReflection->isSubclassOf('Doctrine\Bundle\FixturesBundle\Fixture')) {
            return [];
        }

        $errors = [];

        // 检查匿名类是否实现了 UserInterface
        if ($node->class->implements) {
            foreach ($node->class->implements as $implementedInterface) {
                $interfaceName = $scope->resolveName($implementedInterface);

                if ('Symfony\Component\Security\Core\User\UserInterface' === $interfaceName) {
                    $errors[] = RuleErrorBuilder::message(
                        'DataFixtures 中禁止使用匿名类实现 UserInterface，应该注入 UserManagerInterface 依赖'
                    )
                        ->tip('1. 在构造函数中注入 UserManagerInterface $userManager')
                        ->tip('2. 实现 getOrCreateTestUser() 方法使用 $this->userManager->loadUserByIdentifier() 和 $this->userManager->createUser()')
                        ->tip('3. 参考 ResourceBillFixtures::getOrCreateTestUser() 的实现')
                        ->line($node->getStartLine())
                        ->build()
                    ;
                }
            }
        }

        // 检查是否创建了任何匿名类（即使不实现 UserInterface 也提示）
        if (0 === count($errors) && $node->class instanceof Class_) {
            $errors[] = RuleErrorBuilder::message(
                'DataFixtures 中不建议使用匿名类，应优先使用依赖注入或服务定位器'
            )
                ->tip('考虑是否可以通过注入相应的 Manager 或 Service 来替代匿名类')
                ->line($node->getStartLine())
                ->build()
            ;
        }

        return $errors;
    }
}
