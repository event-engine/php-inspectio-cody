<?php

declare(strict_types=1);

namespace EventEngineTest\InspectioCody\Board;

use EventEngine\InspectioCody\Board\Code;
use EventEngine\InspectioCody\CodyConfig;
use EventEngine\InspectioCody\Http\Message\CodyResponse;
use EventEngine\InspectioGraphCody\Node;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

final class CodeTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_handles_element_on_edit(): void
    {
        $node = $this->prophesize(Node::class);
        $node->name()->willReturn('Test');
        $node->type()->willReturn('Aggregate');

        $response = Code::handleElementEdited($node->reveal(), new CodyConfig([], []));

        $this->assertInstanceOf(CodyResponse::class, $response);
    }
}
