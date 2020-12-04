<?php

/**
 * @see       https://github.com/event-engine/php-inspectio-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-inspectio-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-inspectio-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace EventEngine\InspectioCody\General;

use EventEngine\InspectioCody\Http\Message\CodyResponse;
use EventEngine\InspectioCody\Http\Message\Response;

/** @var callable $currentQuestion */
$currentQuestion = null;

final class Question
{
    public static function checkQuestion(CodyResponse $response): CodyResponse
    {
        if ($response->type() === CodyResponse::QUESTION && $response->reply()) {
            global $currentQuestion;
            $currentQuestion = $response->reply();
        }

        return $response;
    }

    public static function handleReply($reply): CodyResponse
    {
        global $currentQuestion;

        $response = null;

        if ($currentQuestion) {
            $response = $currentQuestion($reply);
            $currentQuestion = null;

            return $response;
        }

        return Response::fromCody(
            'Sorry, not sure what to say.',
            'Did I ask anything?',
            CodyResponse::WARNING
        );
    }

    public static function isAnswerYes(string $answer): bool
    {
        return $answer === 'yes' || $answer === 'y' || $answer === 'true' || $answer === 'Yes' || $answer === 'Y';
    }

    public static function test(): CodyResponse
    {
        return Response::fromCody(
            'Do you like bots?',
            'Answer with: IIO.reply(true|false)',
            CodyResponse::QUESTION,
            static function (bool $yes) {
                return Response::fromCody(
                    $yes ? 'Cool! I like you, too' : 'Oh ok, maybe I can convince you that bots are awesome.',
                    $yes ? ':cody_dance:' : ':tears:',
                );
            }
        );
    }

    private function __construct()
    {
    }
}
