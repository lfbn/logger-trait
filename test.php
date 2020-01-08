<?php

require_once 'vendor/autoload.php';

use Lfbn\LoggerTrait\LoggerTrait;

class SomeClass {

    use LoggerTrait;

    protected static $loggerName = 'some logger';

    public function run()
    {
        $this->initLogger();

        $this->logCritical('This is an error...');
    }
}

(new SomeClass())->run();
