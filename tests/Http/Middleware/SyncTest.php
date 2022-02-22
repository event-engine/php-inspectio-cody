<?php

/**
 * @see       https://github.com/event-engine/php-inspectio-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-inspectio-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-inspectio-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace EventEngineTest\InspectioCody\Http\Middleware;

use EventEngine\InspectioCody\CodyConfig;
use EventEngine\InspectioCody\Http\Middleware\Sync;
use EventEngine\InspectioGraphCody\Node;
use EventEngineTest\InspectioCody\BaseTestCase;
use EventEngineTest\InspectioCody\Mock\Context;
use Prophecy\PhpUnit\ProphecyTrait;
use React\Http\Message\ServerRequest;

final class SyncTest extends BaseTestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_handles_sync_request(): void
    {
        $body = \file_get_contents(self::FILES_DIR . 'sync.json');
        $request = new ServerRequest('POST', '/messages/Sync', [], $body);
        $request = $request->withParsedBody(\json_decode($body, true, 512, JSON_THROW_ON_ERROR));

        $nodesReceived = 0;

        $sync = function (Node $node, Context $context) use (&$nodesReceived) {
            $nodesReceived++;
        };

        $config = new CodyConfig(new Context(false), [CodyConfig::HOOK_ON_SYNC => $sync]);

        $cut = new Sync($config);

        $response = $cut($request, function () {
        });

        $body = $response->getBody();
        $body->rewind();

        $this->assertSame('{"cody":"","details":[],"type":"Empty","reply":null}', $body->getContents());
        $this->assertSame(5, $nodesReceived);
    }
}
