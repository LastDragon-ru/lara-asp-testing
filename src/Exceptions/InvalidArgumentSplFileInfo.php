<?php declare(strict_types = 1);

namespace LastDragon_ru\LaraASP\Testing\Exceptions;

use SplFileInfo;
use Throwable;

use function sprintf;

class InvalidArgumentSplFileInfo extends InvalidArgument {
    public function __construct(
        protected string $argument,
        protected mixed $value,
        ?Throwable $previous = null,
    ) {
        parent::__construct(sprintf(
            'Argument `%1$s` must be instance of `%2$s`, `%3$s` given.',
            $this->argument,
            SplFileInfo::class,
            $this->getType($this->value),
        ), 0, $previous);
    }
}
