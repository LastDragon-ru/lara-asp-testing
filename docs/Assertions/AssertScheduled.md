# `assertScheduled`

Asserts that Schedule contains task.

[include:example]: ./AssertScheduledTest.php
[//]: # (start: 2e2bd1c19dd1317dbeb00c56329568187b473413d8b101293b0f5801076252d3)
[//]: # (warning: Generated automatically. Do not edit.)

```php
<?php declare(strict_types = 1);

namespace LastDragon_ru\LaraASP\Testing\Docs\Assertions;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Foundation\Application;
use LastDragon_ru\LaraASP\Testing\Assertions\Application\ScheduleAssertions;
use LogicException;
use Orchestra\Testbench\TestCase;
use Override;
use PHPUnit\Framework\Attributes\CoversNothing;

/**
 * @internal
 */
#[CoversNothing]
final class AssertScheduledTest extends TestCase {
    /**
     * Trait where assertion defined.
     */
    use ScheduleAssertions;

    #[Override]
    protected function app(): Application {
        return $this->app ?? throw new LogicException('Application not yet initialized.');
    }

    /**
     * Assertion test.
     */
    public function testAssertion(): void {
        // Prepare
        $schedule = $this->app?->make(Schedule::class);

        self::assertNotNull($schedule);

        // Schedule
        $schedule
            ->command('emails:send Example')
            ->daily();
        $schedule
            ->exec('/path/to/command')
            ->daily();

        // Test
        $this->assertScheduled('emails:send Example');
        $this->assertScheduled('/path/to/command');
    }
}
```

[//]: # (end: 2e2bd1c19dd1317dbeb00c56329568187b473413d8b101293b0f5801076252d3)
