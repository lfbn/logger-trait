# Logger Trait

This is a trait that allows you to add logging capabilities to any class.

It uses Monolog, and by default streams to ```php php://output``` but you can change this. Check instructions bellow.

## Usage

```php
// In your class add the use of the Trait
use LoggerTrait;

(...)

// You need to call this method to the logger create an instance of the logger.
$this->initLogger();

(...)

// Or use your own logger.
$this->setLogger($logger);

// After that, you can use it.
$this->logError('Some message...', ['some context']);

// And also interpolate the message.
$this->logError(
    self::interpolateMessage(
        'Some {visibility} message...',
        ['visibility'=>
    ), 
    ['some context']
);
```

### Changing behaviour

```php
// In your class add the following to change the logger.

// logger name
protected static $loggerName = 'my-logger-name';

// logger stream
protected static $loggerStream = 'php://stderr';

// logger stream
protected static $loggerMinimumLevel = LogLevel::DEBUG;
```

### Overriding initLogger

```php
// In your class add the use of the Trait
use LoggerTrait;

(...)

// You can override initLogger method with your own.
public function initLogger()

(...)

// Or use your own logger.
$this->setLogger($logger);

// After that, you can use it.
$this->logError('Some message...', ['some context']);

// And also interpolate the message.
$this->logError(
    self::interpolateMessage(
        'Some {visibility} message...',
        ['visibility'=>
    ), 
    ['some context']
);
```
