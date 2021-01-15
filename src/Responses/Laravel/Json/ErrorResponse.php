<?php declare(strict_types = 1);

namespace LastDragon_ru\LaraASP\Testing\Responses\Laravel\Json;

use LastDragon_ru\LaraASP\Testing\Constraints\JsonMatchesSchema;
use LastDragon_ru\LaraASP\Testing\Constraints\Response\Body;
use LastDragon_ru\LaraASP\Testing\Constraints\Response\ContentTypes\JsonContentType;
use LastDragon_ru\LaraASP\Testing\Constraints\Response\Response;
use LastDragon_ru\LaraASP\Testing\Constraints\Response\StatusCode;
use LastDragon_ru\LaraASP\Testing\Utils\WithTestData;

class ErrorResponse extends Response {
    use WithTestData;

    public function __construct(StatusCode $statusCode) {
        parent::__construct(
            $statusCode,
            new JsonContentType(),
            new Body(
                new JsonMatchesSchema($this->getTestData(self::class)->file('.json')),
            ),
        );
    }
}