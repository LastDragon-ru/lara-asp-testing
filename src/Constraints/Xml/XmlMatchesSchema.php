<?php declare(strict_types = 1);

namespace LastDragon_ru\LaraASP\Testing\Constraints\Xml;

use DOMDocument;
use LastDragon_ru\LaraASP\Testing\Constraints\Xml\Matchers\DomDocumentRelaxNgSchemaMatcher;
use LastDragon_ru\LaraASP\Testing\Constraints\Xml\Matchers\DomDocumentXsdSchemaMatcher;
use LastDragon_ru\LaraASP\Testing\Constraints\Xml\Matchers\XmlFileRelaxNgSchemaMatcher;
use LastDragon_ru\LaraASP\Testing\Constraints\Xml\Matchers\XmlFileXsdSchemaMatcher;
use LastDragon_ru\LaraASP\Testing\Utils\Args;
use LibXMLError;
use Override;
use PHPUnit\Framework\Constraint\Constraint;
use SplFileInfo;

use function libxml_clear_errors;
use function libxml_get_errors;
use function libxml_use_internal_errors;
use function mb_trim;
use function strtolower;

use const LIBXML_ERR_ERROR;
use const LIBXML_ERR_FATAL;
use const LIBXML_ERR_WARNING;
use const PHP_EOL;

class XmlMatchesSchema extends Constraint {
    protected SplFileInfo $schema;
    /**
     * @var array<array-key, LibXMLError>
     */
    protected array $errors = [];

    public function __construct(SplFileInfo $schema) {
        $this->schema = Args::getFile($schema);
    }

    // <editor-fold desc="\PHPUnit\Framework\Constraint\Constraint">
    // =========================================================================
    #[Override]
    public function evaluate(mixed $other, string $description = '', bool $returnResult = false): ?bool {
        if ($other instanceof SplFileInfo) {
            $other = Args::getFile($other);
        } else {
            $other = Args::getDomDocument($other);
        }

        return parent::evaluate($other, $description, $returnResult);
    }

    #[Override]
    protected function matches(mixed $other): bool {
        // Create constraint
        $isRelaxNg  = strtolower($this->schema->getExtension()) === 'rng';
        $constraint = null;

        if ($other instanceof DOMDocument) {
            $constraint = $isRelaxNg
                ? new DomDocumentRelaxNgSchemaMatcher()
                : new DomDocumentXsdSchemaMatcher();
        } elseif ($other instanceof SplFileInfo) {
            $constraint = $isRelaxNg
                ? new XmlFileRelaxNgSchemaMatcher()
                : new XmlFileXsdSchemaMatcher();
        } else {
            // no action
        }

        // Check
        $previous = libxml_use_internal_errors(true);
        libxml_clear_errors();

        try {
            $matches = $constraint !== null && $constraint->isMatchesSchema($this->schema, $other);
        } finally {
            $this->errors = libxml_get_errors();

            libxml_use_internal_errors($previous);
            libxml_clear_errors();
        }

        return $matches;
    }

    #[Override]
    protected function additionalFailureDescription(mixed $other): string {
        $description = parent::additionalFailureDescription($other);
        $levels      = [
            LIBXML_ERR_WARNING => 'Warning',
            LIBXML_ERR_ERROR   => 'Error',
            LIBXML_ERR_FATAL   => 'Fatal Error',
        ];

        foreach ($this->errors as $error) {
            $padding      = '    ';
            $description .= PHP_EOL.$padding.mb_trim("{$levels[$error->level]} #{$error->code}: {$error->message}");
            $description .= PHP_EOL."{$padding}{$error->file}:{$error->line}";
            $description .= PHP_EOL;
        }

        return $description;
    }

    #[Override]
    public function toString(): string {
        return "matches schema {$this->schema->getPathname()}";
    }

    // </editor-fold>
}
