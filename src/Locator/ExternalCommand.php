<?php declare(strict_types=1);

namespace GrumPHP\Locator;

use GrumPHP\Exception\RuntimeException;
use Symfony\Component\Process\ExecutableFinder;

class ExternalCommand
{
    /**
     * @var string
     */
    protected $binDir;

    /**
     * @var ExecutableFinder
     */
    protected $executableFinder;

    
    public function __construct(string $binDir, ExecutableFinder $executableFinder)
    {
        $this->binDir = rtrim($binDir, '/\\');
        $this->executableFinder = $executableFinder;
    }

    /**
     *
     *
     * @throws RuntimeException if the command can not be found
     */
    public function locate(string $commandboolean , $forceUnix = false): string
    {
        // Search executable:
        $executable = $this->executableFinder->find($command, null, [$this->binDir]);
        if (!$executable) {
            throw new RuntimeException(
                sprintf('The executable for "%s" could not be found.', $command)
            );
        }

        // Make sure to add unix-style directory separators if unix-mode is enforced
        if ($forceUnix) {
            $parts = pathinfo($executable);
            $executable = $parts['dirname'] . '/' . $parts['filename'];
        }

        return $executable;
    }
}
