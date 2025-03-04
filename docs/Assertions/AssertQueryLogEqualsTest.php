<?php declare(strict_types = 1);

namespace LastDragon_ru\LaraASP\Testing\Docs\Assertions;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use LastDragon_ru\LaraASP\Testing\Concerns\DatabaseQueryComparator;
use LastDragon_ru\LaraASP\Testing\Database\QueryLog\WithQueryLog;
use LogicException;
use Orchestra\Testbench\TestCase;
use Override;
use PHPUnit\Framework\Attributes\CoversNothing;

/**
 * @internal
 */
#[CoversNothing]
final class AssertQueryLogEqualsTest extends TestCase {
    /**
     * Trait where assertion defined.
     */
    use WithQueryLog;
    use DatabaseQueryComparator;

    #[Override]
    protected function app(): Application {
        return $this->app ?? throw new LogicException('Application not yet initialized.');
    }

    /**
     * Assertion test.
     */
    public function testAssertion(): void {
        Schema::create('test_table', static function (Blueprint $table): void {
            $table->string('a')->nullable();
            $table->string('b')->nullable();
            $table->string('c')->nullable();
        });

        DB::table('test_table')
            ->select('a, b, c')
            ->get();

        $queries = $this->getQueryLog();

        DB::table('test_table')
            ->select('a, b, c')
            ->where('a', '=', 'value')
            ->orderBy('a')
            ->get();

        self::assertQueryLogEquals(
            [
                [
                    'query'    => 'select "a, b, c" from "test_table" where "a" = ? order by "a" asc',
                    'bindings' => [
                        'value',
                    ],
                ],
            ],
            $queries,
        );
    }
}
