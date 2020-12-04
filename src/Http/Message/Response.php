<?php

/**
 * @see       https://github.com/event-engine/php-inspectio-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-inspectio-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-inspectio-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace EventEngine\InspectioCody\Http\Message;

use EventEngine\InspectioGraphCody\Node;
use Fig\Http\Message\StatusCodeInterface;
use RingCentral\Psr7\Response as Psr7Response;

final class Response extends Psr7Response implements CodyResponse
{
    /**
     * @var string | string[]
     */
    private $cody;

    /**
     * @var string | string[]|null
     */
    private $details;

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var callable|null
     */
    private $reply;

    public static function fromCody($cody, $details = [], $type = CodyResponse::INFO, callable $reply = null): CodyResponse
    {
        $body = \json_encode(
            [
                'cody' => $cody,
                'details' => $details,
                'type' => $type,
                'reply' => $reply,
            ]
        );

        $self = new self(
            StatusCodeInterface::STATUS_OK,
            ['Content-Type' => 'application/json'],
            $body
        );

        $self->cody = $cody;
        $self->details = $details;
        $self->type = $type;
        $self->reply = $reply;

        return $self;
    }

    /**
     * @param string $question
     * @param callable $callback
     * @param string|string[]|null $answer
     * @return CodyResponse
     */
    public static function question(string $question, callable $callback, $answer = 'Answer with: yes/no'): CodyResponse
    {
        return self::fromCody(
            \sprintf($question),
            $answer,
            self::QUESTION,
            $callback
        );
    }

    public static function error(string $error, array $details = []): CodyResponse
    {
        return self::fromCody(
            $error,
            $details,
            self::ERROR
        );
    }

    public static function noJsonRequest(): CodyResponse
    {
        return self::fromCody(
            \sprintf("Sorry, I don't understand you! Can you talk with 'application/json' to me please?"),
            [
                'If you need guidance just ask me with: %cIIO.ask.Cody.forHelp()',
                'background-color: rgba(251, 159, 75, 0.2)',
            ],
        );
    }

    public static function fromException(Node $node, \Throwable $e): CodyResponse
    {
        return self::fromCody(
            \sprintf(
                'Oh no, something goes wrong with "%s". Please tell me how to solve it.',
                $node->name(),
            ),
            [
                $e->getMessage(),
                (string) $e,
            ],
            self::ERROR
        );
    }

    /**
     * @return string|string[]
     */
    public function cody()
    {
        return $this->cody;
    }

    /**
     * @return string|string[]|null
     */
    public function details()
    {
        return $this->details;
    }

    /**
     * @return callable|null
     */
    public function reply(): ?callable
    {
        return $this->reply;
    }

    /**
     * @return string|null
     */
    public function type(): ?string
    {
        return $this->type;
    }
}
