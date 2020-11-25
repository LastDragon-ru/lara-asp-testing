<?php declare(strict_types = 1);

namespace LastDragon_ru\LaraASP\Testing\Mixins;

use LastDragon_ru\LaraASP\Testing\Assertions\JsonAssertions;
use LastDragon_ru\LaraASP\Testing\Assertions\ResponseAssertions;
use PHPUnit\Framework\Assert as PHPUnitAssert;

/**
 * @internal
 */
class Assert extends PHPUnitAssert {
    use JsonAssertions;
    use ResponseAssertions;
}