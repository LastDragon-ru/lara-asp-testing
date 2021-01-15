<?php declare(strict_types = 1);

namespace LastDragon_ru\LaraASP\Testing\Responses\Laravel\Json;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use LastDragon_ru\LaraASP\Testing\Package\TestCase;

/**
 * @internal
 * @coversDefaultClass \LastDragon_ru\LaraASP\Testing\Responses\Laravel\Json\ValidationErrorResponse
 */
class ValidationErrorResponseTest extends TestCase {
    // <editor-fold desc="Tests">
    // =========================================================================
    /**
     * @covers ::evaluate
     *
     * @dataProvider dataProviderEvaluate
     *
     * @param bool       $expected
     * @param array      $rules
     * @param array|null $errors
     *
     * @return void
     */
    public function testEvaluate(bool $expected, array $rules, ?array $errors): void {
        Route::get(__FUNCTION__, function (Request $request) use ($rules) {
            return $request->validate($rules);
        });

        $response   = $this->getJson(__FUNCTION__)->toPsrResponse();
        $constraint = new ValidationErrorResponse($errors);

        $this->assertEquals($expected, $constraint->evaluate($response, '', true));
    }
    // </editor-fold>

    // <editor-fold desc="DataProviders">
    // =========================================================================
    public function dataProviderEvaluate(): array {
        return [
            'no rules'                     => [
                false,
                [],
                null,
            ],
            'failed + any error'           => [
                true,
                [
                    'title' => 'required|min:3|max:5',
                ],
                null,
            ],
            'failed + error + any message' => [
                true,
                [
                    'title' => 'required|min:3|max:5',
                ],
                [
                    'title' => null,
                ],
            ],
            'failed + error + message'     => [
                true,
                [
                    'title' => 'required|min:3|max:5',
                ],
                [
                    'title' => 'The title field is required.',
                ],
            ],
        ];
    }

    // </editor-fold>
}