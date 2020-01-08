<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Lfbn\LoggerTrait\LoggerTrait;

/**
 * Class LoggerTraitTest
 */
class LoggerTraitTest extends TestCase
{

    use LoggerTrait;

    /**
     * @dataProvider interpolateMessageDataProvider
     * @param string $message
     * @param array $context
     * @param string $expected
     */
    public function testItShouldInterpolateAMessage(
        string $message,
        array $context,
        string $expected
    ): void
    {
        $message = self::interpolateMessage(
            $message,
            $context
        );

        $this->assertEquals(
            $expected,
            $message
        );
    }

    /**
     * @return array
     */
    public function interpolateMessageDataProvider(): array
    {
        return [
            'with one variable' => [
                'This is a {visibility} message...',
                ['visibility'=>'secret'],
                'This is a secret message...'
            ],
            'with two variables' => [
                'This is a {visibility} message that is {message}...',
                ['visibility'=>'public', 'message' => 'public message'],
                'This is a public message that is public message...'
            ]
        ];
    }
}
