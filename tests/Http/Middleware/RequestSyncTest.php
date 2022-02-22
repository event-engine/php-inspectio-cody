<?php

/**
 * @see       https://github.com/event-engine/php-inspectio-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-inspectio-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-inspectio-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace EventEngineTest\InspectioCody\Http\Middleware;

use EventEngine\InspectioCody\CodyConfig;
use EventEngine\InspectioCody\Http\Middleware\RequestSync;
use EventEngineTest\InspectioCody\BaseTestCase;
use EventEngineTest\InspectioCody\Mock\Context;
use Prophecy\PhpUnit\ProphecyTrait;
use React\Http\Message\ServerRequest;

final class RequestSyncTest extends BaseTestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_handles_request_sync_request(): void
    {
        $request = new ServerRequest('POST', '/messages/ElementEdited', []);

        $config = new CodyConfig(new Context(true), []);

        $cut = new RequestSync($config);

        $response = $cut($request, function () {
        });

        $body = $response->getBody();
        $body->rewind();

        $this->assertSame('{"cody":"I need to sync all elements first.","details":["Lean back for a moment. I\'ll let you know when I\'m done."],"type":"SyncRequired","reply":null}', $body->getContents());
    }
}
