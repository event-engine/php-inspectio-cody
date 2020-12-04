<?php

/**
 * @see       https://github.com/event-engine/php-inspectio-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-inspectio-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-inspectio-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace EventEngine\InspectioCody\Board\Exception;

use EventEngine\InspectioCody\Http\Message\CodyResponse;
use EventEngine\InspectioCody\Http\Message\Response;

final class CodyQuestion extends \RuntimeException
{
    /**
     * @var CodyResponse
     */
    private $response;

    private function __construct($message = '', $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function withQuestionResponse(CodyResponse $response): self
    {
        $self = new self('Question');
        $self->response = $response;

        return $self;
    }

    /**
     * @param string $question
     * @param callable $callback
     * @param string|string[]|null $answer
     * @return self
     */
    public static function withQuestion(string $question, callable $callback, $answer = 'Answer with: yes/no'): self
    {
        return self::withQuestionResponse(Response::question($question, $callback, $answer));
    }

    /**
     * @return CodyResponse
     */
    public function response(): CodyResponse
    {
        return $this->response;
    }
}
