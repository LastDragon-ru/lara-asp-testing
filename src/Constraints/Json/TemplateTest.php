<?php declare(strict_types = 1);

namespace LastDragon_ru\LaraASP\Testing\Constraints\Json;

use Exception;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;

use function json_decode;

/**
 * @internal
 * @coversDefaultClass \LastDragon_ru\LaraASP\Testing\Constraints\Json\Template
 */
class TemplateTest extends TestCase {
    // <editor-fold desc="Tests">
    // =========================================================================
    /**
     * @covers ::build
     *
     * @dataProvider dataProviderBuild
     *
     * @param array<string,string> $parameters
     */
    public function testBuild(Exception|string $expected, string $content, array $parameters): void {
        if ($expected instanceof Exception) {
            $this->expectExceptionObject($expected);
        }

        $actual = (new Template($content))->build($parameters);

        $this->assertEquals($expected, $actual);
        $this->assertNotNull(json_decode($actual));
    }
    // </editor-fold>

    // <editor-fold desc="DataProviders">
    // =========================================================================
    /**
     * @return array<string,array<string|null, string, array<string,string>>>
     */
    public function dataProviderBuild(): array {
        return [
            'template without parameters'    => [
                '{"a": "b"}',
                '{"a": "b"}',
                [],
            ],
            'template with parameters'       => [
                '{"\\"a\\"": ["\\"a\\"", "b"]}',
                '{"${a}": ["${a}", "${b}"]}',
                [
                    'a' => '"a"',
                    'b' => 'b',
                ],
            ],
            'template with missed parameter' => [
                new OutOfBoundsException('Required parameter `b` is missed.'),
                '{"${a}": ["${a}", "${b}"]}',
                [
                    'a' => 'a',
                ],
            ],
        ];
    }
    // </editor-fold>
}
