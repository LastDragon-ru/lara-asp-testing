<?php declare(strict_types = 1);

namespace LastDragon_ru\LaraASP\Testing\Assertions;

use LastDragon_ru\LaraASP\Testing\Constraints\Xml\XmlMatchesSchemaTest;
use LastDragon_ru\LaraASP\Testing\Utils\TestData;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversDefaultClass \LastDragon_ru\LaraASP\Testing\Assertions\XmlAssertions
 */
class XmlAssertionsTest extends TestCase {
    /**
     * @covers ::assertXmlMatchesSchema
     */
    public function testAssertXmlMatchesSchema(): void {
        $data      = new TestData(XmlMatchesSchemaTest::class);
        $assertion = new class() extends Assert {
            use XmlAssertions;
        };

        $assertion->assertXmlMatchesSchema($data->file('.rng'), $data->dom('.xml'));
        $assertion->assertXmlMatchesSchema($data->file('.xsd'), $data->dom('.xml'));
        $assertion->assertXmlMatchesSchema($data->file('.rng'), $data->file('.xml'));
        $assertion->assertXmlMatchesSchema($data->file('.xsd'), $data->file('.xml'));
    }
}
