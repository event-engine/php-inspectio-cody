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

final class CodyError extends \RuntimeException
{
    /**
     * @var CodyResponse
     */
    private $response;

    private function __construct($message = '', $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function withErrorResponse(CodyResponse $response): self
    {
        $self = new self('Error');
        $self->response = $response;

        return $self;
    }

    public static function withError(string $error, array $details = []): self
    {
        return self::withErrorResponse(Response::error($error, $details));
    }

    /**
     * @return CodyResponse
     */
    public function response(): CodyResponse
    {
        return $this->response;
    }
}
