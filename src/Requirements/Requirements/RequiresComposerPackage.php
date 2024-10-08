<?php declare(strict_types = 1);

namespace LastDragon_ru\LaraASP\Testing\Requirements\Requirements;

use Attribute;
use Composer\InstalledVersions;
use Composer\Semver\VersionParser;
use LastDragon_ru\LaraASP\Testing\Requirements\PhpUnit\Extension;
use LastDragon_ru\LaraASP\Testing\Requirements\Requirement;
use Override;

use function sprintf;

/**
 * @see Extension
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class RequiresComposerPackage implements Requirement {
    /**
     * @param non-empty-string      $package
     * @param non-empty-string|null $version
     */
    public function __construct(
        protected readonly string $package,
        protected readonly ?string $version = null,
    ) {
        // empty
    }

    #[Override]
    public function isSatisfied(): bool {
        return $this->version !== null
            ? InstalledVersions::satisfies(new VersionParser(), $this->package, $this->version)
            : InstalledVersions::isInstalled($this->package);
    }

    #[Override]
    public function __toString(): string {
        return sprintf(
            'The package `%s` is not installed.',
            $this->package.($this->version !== null ? ":{$this->version}" : ''),
        );
    }
}
