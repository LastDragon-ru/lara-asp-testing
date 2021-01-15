<?php declare(strict_types = 1);

namespace LastDragon_ru\LaraASP\Testing\Constraints\Xml;

use LastDragon_ru\LaraASP\Testing\Utils\WithTestData;
use PHPUnit\Framework\TestCase;
use function is_string;

/**
 * @internal
 * @coversDefaultClass \LastDragon_ru\LaraASP\Testing\Constraints\Xml\XmlMatchesSchema
 */
class XmlMatchesSchemaTest extends TestCase {
    use WithTestData;

    // <editor-fold desc="Tests">
    // =========================================================================
    /**
     * @dataProvider dataProviderEvaluate
     *
     * @param bool|string                      $expected
     * @param \SplFileInfo                     $schema
     * @param \SplFileInfo|\DOMDocument|string $xml
     */
    public function testEvaluate($expected, \SplFileInfo $schema, $xml): void {
        $constraint = new class($schema) extends XmlMatchesSchema {
            public function additionalFailureDescription($other): string {
                return parent::additionalFailureDescription($other);
            }
        };
        $result     = $constraint->evaluate($xml, '', true);

        if (is_string($expected)) {
            $this->assertFalse($result);
            $this->assertStringContainsString($expected, $constraint->additionalFailureDescription($xml));
        } else {
            $this->assertEquals($expected, $result);
        }
    }
    // </editor-fold>

    // <editor-fold desc="DataProviders">
    // =========================================================================
    public function dataProviderEvaluate(): array {
        return [
            'rng + dom = valid'    => [
                true,
                $this->getTestData()->file('.rng'),
                $this->getTestData()->dom('.xml'),
            ],
            'rng + dom = invalid'  => [
                'Error #38: Did not expect element a there',
                $this->getTestData()->file('.rng'),
                $this->getTestData()->dom('.invalid.xml'),
            ],
            'xsd + dom = valid'    => [
                true,
                $this->getTestData()->file('.xsd'),
                $this->getTestData()->dom('.xml'),
            ],
            'xsd + dom = invalid'  => [
                "Error #1871: Element 'a': This element is not expected. Expected is ( child )",
                $this->getTestData()->file('.xsd'),
                $this->getTestData()->dom('.invalid.xml'),
            ],
            'rng + file = valid'   => [
                true,
                $this->getTestData()->file('.rng'),
                $this->getTestData()->file('.xml'),
            ],
            'rng + file = invalid' => [
                'Error #38: Did not expect element a there',
                $this->getTestData()->file('.rng'),
                $this->getTestData()->file('.invalid.xml'),
            ],
            'xsd + file = valid'   => [
                true,
                $this->getTestData()->file('.xsd'),
                $this->getTestData()->file('.xml'),
            ],
            'xsd + file = invalid' => [
                "Error #1871: Element 'a': This element is not expected. Expected is ( child )",
                $this->getTestData()->file('.xsd'),
                $this->getTestData()->file('.invalid.xml'),
            ],
        ];
    }
    // </editor-fold>
}