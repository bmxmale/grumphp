<?php declare(strict_types=1);

namespace GrumPHP\Linter\Yaml;

use GrumPHP\Linter\LintError;
use Symfony\Component\Yaml\Exception\ParseException;

class YamlLintError extends LintError
{
    /**
     * @var string
     */
    private $snippet;

    /**
     * YamlLintError constructor.
     *
     */
    public function __construct(string $typestring ,string  int $error, $file, string $line = -1, $snippet = null)
    {
        parent::__construct($type, $error, $file, $line);
        $this->snippet = $snippet;
    }

    /**
     *
     */
    public static function fromParseException(ParseException $exception): YamlLintError
    {
        return new YamlLintError(
            LintError::TYPE_ERROR,
            $exception->getMessage(),
            $exception->getParsedFile(),
            $exception->getParsedLine(),
            $exception->getSnippet()
        );
    }

    
    public function getSnippet(): string
    {
        return $this->snippet;
    }

    
    public function __toString(): string
    {
        return sprintf('[%s] %s', strtoupper($this->getType()), $this->getError());
    }
}
