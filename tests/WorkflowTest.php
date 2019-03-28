<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Godbout\Alfred\Kat\Workflow;

class WorkflowTest extends TestCase
{
    /** @test */
    public function it_can_search_for_torrents_on_the_kat_site()
    {
        putenv('url=https://kickass.sx/torrent/usearch/');

        $this->assertStringContainsString(
            'Fight Club (1999)',
            Workflow::resultsFor('fight club')
        );
    }
}
