<?php declare(strict_types = 1);

namespace LastDragon_ru\LaraASP\Testing\Responses\Laravel\Json;

use LastDragon_ru\LaraASP\Testing\Constraints\Response\StatusCodes\Unauthorized;

class UnauthorizedResponse extends ErrorResponse {
    public function __construct() {
        parent::__construct(new Unauthorized());
    }
}
