<?php declare(strict_types = 1);

namespace LastDragon_ru\LaraASP\Testing\Assertions\Application\ScheduleMatchers;

use Illuminate\Console\Application;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Container\Container;
use LastDragon_ru\LaraASP\Testing\Assertions\Application\ScheduleMatcher;
use Override;
use Symfony\Component\Console\Command\Command;

use function array_filter;
use function array_unique;
use function in_array;
use function is_a;
use function is_string;

/**
 * @internal
 */
class CommandMatcher implements ScheduleMatcher {
    public function __construct() {
        // empty
    }

    #[Override]
    public function isMatch(Event $event, mixed $task): bool {
        // Command?
        if (!isset($event->command)) {
            return false;
        }

        // Check
        $variants = match (true) {
            is_string($task) && is_a($task, Command::class, true) => array_unique(array_filter([
                Application::formatCommandString(Container::getInstance()->make($task)->getName() ?? ''),
                Application::formatCommandString($task::getDefaultName() ?? ''),
            ])),
            is_string($task)                                      => [
                Application::formatCommandString($task),
                $task,
            ],
            default                                               => [
                // empty
            ],
        };

        return in_array($event->command, $variants, true);
    }
}
