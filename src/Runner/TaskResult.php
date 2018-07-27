<?php declare(strict_types=1);

namespace GrumPHP\Runner;

use GrumPHP\Task\Context\ContextInterface;
use GrumPHP\Task\TaskInterface;

class TaskResult implements TaskResultInterface
{
    const SKIPPED = -100;
    const PASSED = 0;
    const NONBLOCKING_FAILED = 90;
    const FAILED = 99;

    /**
     * @var integer
     */
    private $resultCode;

    /**
     * @var TaskInterface
     */
    private $task;

    /**
     * @var ContextInterface
     */
    private $context;

    /**
     * @var string|null
     */
    private $message;

    /**
     * Initializes test result.
     *
     * @param string|null $message
     */
    private function __construct(integer $resultCode, TaskInterface $task, ContextInterface $context, $message = null)
    {
        $this->resultCode = $resultCode;
        $this->task = $task;
        $this->context = $context;
        $this->message = $message;
    }

    /**
     *
     */
    public static function createSkipped(TaskInterface $task, ContextInterface $context): TaskResult
    {
        return new self(self::SKIPPED, $task, $context);
    }

    /**
     *
     */
    public static function createPassed(TaskInterface $task, ContextInterface $context): TaskResult
    {
        return new self(self::PASSED, $task, $context, null);
    }

    /**
     *
     */
    public static function createFailed(TaskInterface $task, ContextInterface $context, string $message): TaskResult
    {
        return new self(self::FAILED, $task, $context, $message);
    }

    /**
     *
     */
    public static function createNonBlockingFailed(TaskInterface $task, ContextInterface $context, string $message): TaskResult
    {
        return new self(self::NONBLOCKING_FAILED, $task, $context, $message);
    }

    
    public function getTask(): TaskInterface
    {
        return $this->task;
    }

    
    public function getResultCode(): int
    {
        return $this->resultCode;
    }

    
    public function isPassed(): bool
    {
        return self::PASSED === $this->getResultCode();
    }

    public function hasFailed()
    {
        return self::FAILED === $this->getResultCode() || self::NONBLOCKING_FAILED === $this->getResultCode();
    }

    
    public function isBlocking(): bool
    {
        return $this->getResultCode() >= self::FAILED;
    }

    /**
     * @return null|string
     */
    public function getMessage()
    {
        return $this->message;
    }

    
    public function getContext(): ContextInterface
    {
        return $this->context;
    }
}
