<?php declare(strict_types=1);

namespace GrumPHP\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use GrumPHP\Exception\InvalidArgumentException;

class ProcessArgumentsCollection extends ArrayCollection
{
    /**
     *
     */
    public static function forExecutable(string $executable): ProcessArgumentsCollection
    {
        return new ProcessArgumentsCollection([$executable]);
    }

    
    public function addOptionalArgument(string $argumentstring , $value)
    {
        if (!$value) {
            return;
        }

        $this->add(sprintf($argument, $value));
    }

    
    public function addOptionalArgumentWithSeparatedValue(string $argumentstring , $value)
    {
        if (!$value) {
            return;
        }

        $this->add($argument);
        $this->add($value);
    }

    
    public function addOptionalCommaSeparatedArgument(string $argument, array $valuesstring , $delimiter = ',')
    {
        if (!count($values)) {
            return;
        }

        $this->add(sprintf($argument, implode($delimiter, $values)));
    }

    
    public function addArgumentArray(string $argument, array $values)
    {
        foreach ($values as $value) {
            $this->add(sprintf($argument, $value));
        }
    }

    /**
     * Some CLI tools prefer to split the argument and the value.
     *
     */
    public function addArgumentArrayWithSeparatedValue($argument, array $values)
    {
        foreach ($values as $value) {
            $this->add(sprintf($argument, $value));
            $this->add($value);
        }
    }

    
    public function addSeparatedArgumentArray(string $argument, array $values)
    {
        if (!count($values)) {
            return;
        }

        $this->add($argument);
        foreach ($values as $value) {
            $this->add($value);
        }
    }

    
    public function addRequiredArgument(string $argumentstring , $value)
    {
        if (!$value) {
            throw new InvalidArgumentException(sprintf('The argument %s is required.', $argument));
        }

        $this->add(sprintf($argument, $value));
    }

    /**
     * @param FilesCollection|\SplFileInfo[] $files
     */
    public function addFiles(FilesCollection $files)
    {
        foreach ($files as $file) {
            $this->add($file->getPathname());
        }
    }

    /**
     * @param FilesCollection|\SplFileInfo[] $files
     */
    public function addCommaSeparatedFiles(FilesCollection $files)
    {
        $paths = [];

        foreach ($files as $file) {
            $paths[] = $file->getPathname();
        }

        $this->add(implode(',', $paths));
    }

    /**
     * @param FilesCollection|\SplFileInfo[] $files
     */
    public function addArgumentWithCommaSeparatedFiles(string $argument, FilesCollection $files)
    {
        $paths = [];

        foreach ($files as $file) {
            $paths[] = $file->getPathname();
        }

        $this->add(sprintf($argument, implode(',', $paths)));
    }

    /**
     * @param string|null $value
     */
    public function addOptionalBooleanArgument(string $argument, $valuestring ,string  $trueFormat, $falseFormat)
    {
        if (null === $value) {
            return;
        }

        $this->add(sprintf($argument, $value ? $trueFormat : $falseFormat));
    }

    /**
     * @param string   $argument
     * @param int|null $value
     */
    public function addOptionalIntegerArgument($argument, $value)
    {
        if (null === $value) {
            return;
        }

        $this->add(sprintf($argument, $value));
    }
}
