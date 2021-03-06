<?php declare(strict_types = 1);

namespace LastDragon_ru\LaraASP\Testing\Providers;

use Traversable;

use function iterator_to_array;

class TraversableDataProvider extends BaseDataProvider {
    private Traversable $traversable;

    public function __construct(Traversable $traversable) {
        $this->traversable = $traversable;
    }

    /**
     * @return array<mixed>
     */
    public function getData(bool $raw = false): array {
        return $this->replaceExpectedValues(iterator_to_array($this->traversable), $raw);
    }
}
