# Logger Trait

This is a Trait that allows to have logging capabilities in any class.

By default, it uses Monolog and streams to standard output, but you can override this behaviour.

## Installation

```bash
composer require lfbn/logger-trait
```

## Usage

### Using the default behaviour

```php
// In the class you want, add the use of the Trait.
use LoggerTrait;

(...)

// After that, you can use it.
$this->logError('Some message...', ['some context']);
```

### Changing name, stream or minimum level

```php
// Implement the following protected properties.
/* @var string */
protected static $loggerName = 'my-logger-name';

/* @var string */
protected static $loggerStream = 'php://stdout';

/* @var string */
protected static $loggerMinimumLevel = LogLevel::DEBUG;
```

### Overriding the default behaviour

```php
class MyClass {
   protected function initLogger(): bool
   {
       $this->logger = new \Monolog\Logger('Overriding default logger: '.$this->getLoggerName());

       try {
           $handler = new StreamHandler(
               $this->getLoggerStream(),
               $this->getLoggerMinimumLevel()
           );
           $this->logger->pushHandler($handler);
       } catch (Exception $e) {
           $this->logger = new NullLogger();

           return false;
       }

       return true;
   }
}
```

### Inject your own logger

```php
class Test {
    use \Lfbn\LoggerTrait\LoggerTrait;
    public function test(): void
    {
        $this->logDebug('Hello TEST!');
    }
}

$logger = new \Monolog\Logger('test4-my-own-logger');

try {
    $handler = new StreamHandler(
        'php://stdout',
        'debug'
    );
    $logger->pushHandler($handler);
} catch (Exception $e) {
    $logger = new NullLogger();

    return false;
}

$myClass = (new Test());
$myClass->setLogger($logger);
$myClass->test();
```

### Interpolate messages

$this->logWarning(
            self::interpolateMessage(
                'Hello my {private} TEST5!',
                ['private' => 'message']
            ),
        );
