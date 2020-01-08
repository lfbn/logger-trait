<?php
declare(strict_types=1);

namespace Lfbn\LoggerTrait;

use Exception;
use InvalidArgumentException;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Psr\Log\NullLogger;
use RuntimeException;

/**
 * Trait LoggerTrait
 * @package Lfbn\LoggerTrait
 */
trait LoggerTrait
{

    /* @var string */
    private static $_loggerName = 'default';

    /* @var string */
    private static $_loggerStream = 'php://stdout';

    /* @var string */
    private static $_loggerMinimumLevel = LogLevel::WARNING;

    /* @var LoggerInterface */
    protected $logger;

    /* @return $this */
    protected function initLogger(): self
    {
        $this->logger = new Logger($this->getLoggerName());

        try {
            $handler = new StreamHandler(
                $this->getLoggerStream(),
                $this->getLoggerMinimumLevel()
            );
            $this->logger->pushHandler($handler);
        } catch (Exception $e) {
            $this->logger = new NullLogger();
        }

        return $this;
    }

    /**
     * @return string
     */
    private function getLoggerName(): string
    {
        return self::$loggerName ?? self::$_loggerName;
    }

    /**
     * @return string
     */
    private function getLoggerStream(): string
    {
        return self::$loggerStream ?? self::$_loggerStream;
    }

    /**
     * @return string
     */
    private function getLoggerMinimumLevel(): string
    {
        return self::$loggerMinimumLevel ?? self::$_loggerMinimumLevel;
    }

    /**
     * @param LoggerInterface $logger
     * @return LoggerTrait
     */
    public function setLogger(LoggerInterface $logger): self
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * error message
     * @param string $message
     * @param array $context
     * @return $this
     */
    public function logEmergency(string $message, array $context = array()): self
    {
        return $this->_log(
            $message,
            $context,
            LogLevel::EMERGENCY
        );
    }

    /**
     * error message
     * @param string $message
     * @param array $context
     * @return $this
     */
    public function logAlert(string $message, array $context = array()): self
    {
        return $this->_log(
            $message,
            $context,
            LogLevel::ALERT
        );
    }

    /**
     * error message
     * @param string $message
     * @param array $context
     * @return $this
     */
    public function logCritical(string $message, array $context = array()): self
    {
        return $this->_log(
            $message,
            $context,
            LogLevel::CRITICAL
        );
    }

    /**
     * error message
     * @param string $message
     * @param array $context
     * @return $this
     */
    public function logError(string $message, array $context = array()): self
    {
        return $this->_log(
            $message,
            $context,
            LogLevel::ERROR
        );
    }

    /**
     * error message
     * @param string $message
     * @param array $context
     * @return $this
     */
    public function logWarning(string $message, array $context = array()): self
    {
        return $this->_log(
            $message,
            $context,
            LogLevel::WARNING
        );
    }

    /**
     * error message
     * @param string $message
     * @param array $context
     * @return $this
     */
    public function logNotice(string $message, array $context = array()): self
    {
        return $this->_log(
            $message,
            $context,
            LogLevel::NOTICE
        );
    }

    /**
     * error message
     * @param string $message
     * @param array $context
     * @return $this
     */
    public function logInfo(string $message, array $context = array()): self
    {
        return $this->_log(
            $message,
            $context,
            LogLevel::INFO
        );
    }

    /**
     * error message
     * @param string $message
     * @param array $context
     * @return $this
     */
    public function logDebug(string $message, array $context = array()): self
    {
        return $this->_log(
            $message,
            $context,
            LogLevel::DEBUG
        );
    }

    /**
     * @param string $level
     * @param string $message
     * @param array $context
     * @return LoggerTrait
     */
    public function log(string $level, string $message, array $context = array()): self
    {
        return $this->_log(
            $message,
            $context,
            $level
        );
    }

    /**
     * @param $message
     * @param array $context
     * @return string
     * @link https://www.php-fig.org/psr/psr-3/#12-message
     */
    public static function interpolateMessage($message, array $context = array()): string
    {
        $replace = array();

        foreach ($context as $key => $val) {
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        return strtr($message, $replace);
    }

    /**
     * @param string $message
     * @param $context
     * @param string $level
     * @return $this
     */
    private function _log(string $message, $context, string $level): self
    {
        $this->checkLoggerPreConditions();

        if (!method_exists($this->logger, $level)) {
            throw new InvalidArgumentException('The logger doesn\'t have the level you requested.');
        }

        $this->logger->{$level}($message, $context);

        return $this;
    }

    private function checkLoggerPreConditions(): void
    {
        if (!isset($this->logger)) {
            throw new RuntimeException('This trait should be initialized first. Use initLogger method.');
        }
    }
}
