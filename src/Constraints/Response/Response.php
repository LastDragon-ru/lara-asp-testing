<?php declare(strict_types = 1);

namespace LastDragon_ru\LaraASP\Testing\Constraints\Response;

use LastDragon_ru\LaraASP\Testing\Providers\CompositeExpectedImpl;
use LastDragon_ru\LaraASP\Testing\Providers\CompositeExpectedInterface;
use LastDragon_ru\LaraASP\Testing\Utils\Args;
use PHPUnit\Framework\Constraint\Constraint as PHPUnitConstraint;
use PHPUnit\Framework\Constraint\LogicalAnd;
use Psr\Http\Message\ResponseInterface;
use function array_filter;
use function array_map;
use function array_unique;
use function explode;
use function implode;
use function in_array;
use function is_null;
use function mb_strtolower;
use function str_ends_with;
use function str_starts_with;
use function var_dump;
use const PHP_EOL;

class Response extends PHPUnitConstraint implements CompositeExpectedInterface {
    use CompositeExpectedImpl;

    /**
     * @var array|\PHPUnit\Framework\Constraint\Constraint[]
     */
    protected array              $constraints;
    protected ?PHPUnitConstraint $failed = null;

    public function __construct(PHPUnitConstraint ...$constraints) {
        $this->constraints = $constraints;
    }

    /**
     * @return array|\PHPUnit\Framework\Constraint\Constraint[]
     */
    public function getConstraints(): array {
        return $this->constraints;
    }

    // <editor-fold desc="\PHPUnit\Framework\Constraint\Constraint">
    // =========================================================================
    /**
     * @inheritdoc
     *
     * @param \Psr\Http\Message\ResponseInterface $other
     * @param string                              $description
     * @param bool                                $returnResult
     *
     * @return bool|null
     */
    public function evaluate($other, string $description = '', bool $returnResult = false): ?bool {
        return parent::evaluate(
            Args::getResponse($other) ?? Args::invalidResponse(),
            $description,
            $returnResult);
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $other
     *
     * @return bool
     */
    protected function matches($other): bool {
        $matches      = true;
        $this->failed = null;

        foreach ($this->getConstraints() as $constraint) {
            if (!$this->isConstraintMatches($other, $constraint)) {
                $matches      = false;
                $this->failed = $constraint;
                break;
            }
        }

        return $matches;
    }

    public function toString(): string {
        return is_null($this->failed)
            ? LogicalAnd::fromConstraints(...$this->getConstraints())->toString()
            : $this->failed->toString();
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $other
     * @param bool                                $root
     *
     * @return string
     */
    protected function additionalFailureDescription($other, bool $root = true): string {
        $description = [];

        if ($this->failed) {
            $description[] = $this->failed instanceof Response
                ? $this->failed->additionalFailureDescription($other, false)
                : $this->failed->additionalFailureDescription($other);
        }

        if ($root) {
            $description[] = $this->getResponseDescription($other);
        }

        $description = array_map(function (string $text) {
            return trim($text, PHP_EOL);
        }, $description);
        $description = array_unique($description);
        $description = array_filter($description);
        $description = $description
            ? PHP_EOL.implode(PHP_EOL.PHP_EOL, $description).PHP_EOL
            : '';

        return $description;
    }
    // </editor-fold>

    // <editor-fold desc="Functions">
    // =========================================================================
    protected function isConstraintMatches(ResponseInterface $other, PHPUnitConstraint $constraint): bool {
        return $constraint->evaluate($other, '', true);
    }

    protected function getResponseDescription(ResponseInterface $response): string {
        $contentType = mb_strtolower(explode(';', $response->getHeaderLine('Content-Type'))[0]);
        $isText      = false
            || str_starts_with($contentType, 'text/')   // text
            || str_ends_with($contentType, '+xml')      // xml based
            || str_ends_with($contentType, '+json')     // json based
            || in_array($contentType, [                 // other
                'application/json',
            ], true);
        $description = $isText
            ? PHP_EOL.((string) $response->getBody())
            : '';

        return $description;
    }
    // </editor-fold>
}