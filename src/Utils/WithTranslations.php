<?php declare(strict_types = 1);

namespace LastDragon_ru\LaraASP\Testing\Utils;

use Illuminate\Contracts\Translation\Translator;
use Illuminate\Foundation\Testing\TestCase as IlluminateTestCase;
use Illuminate\Translation\Translator as TranslatorImpl;
use LastDragon_ru\LaraASP\Testing\Exceptions\TranslatorUnsupported;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

use function is_callable;

/**
 * @mixin IlluminateTestCase
 * @mixin TestbenchTestCase
 */
trait WithTranslations {
    /**
     * @phpcs:ignore Generic.Files.LineLength.TooLong
     * @param callable(IlluminateTestCase|TestbenchTestCase, string $currentLocale, string $fallbackLocale): array<string,array<string,string>>|array<string,array<string,string>>|null $translations
     */
    public function setTranslations(callable|array|null $translations): void {
        // Translator
        $translator = $this->app->make(Translator::class);

        if (!($translator instanceof TranslatorImpl)) {
            throw new TranslatorUnsupported($translator::class);
        }

        // Prepare
        if (is_callable($translations)) {
            $translations = $translations($this, $translator->getLocale(), $translator->getFallback());
        }

        // Replace
        foreach ((array) $translations as $locale => $lines) {
            WithTranslationsHelper::replaceLines($translator, $locale, $lines);
        }
    }
}