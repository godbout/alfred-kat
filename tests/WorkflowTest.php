<?php

namespace Tests;

use Godbout\Alfred\Kat\Workflow;
use PHPUnit\Framework\TestCase;

class WorkflowTest extends TestCase
{
    /** @test */
    public function it_can_search_for_torrents_on_the_kat_site()
    {
        $this->assertStringContainsString(
            'Fight Club (1999)',
            Workflow::resultsFor('fight club')
        );
    }
}
