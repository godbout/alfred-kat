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

    /** @test */
    public function it_tells_the_user_that_there_is_no_item_found_if_well_there_is_no_item_found()
    {
        putenv('url=https://kickass.sx/torrent/usearch/');

        $this->assertStringContainsString(
            'not found',
            Workflow::resultsFor('kjeriuhsdvfiuqherfiushvsliudfhgsidlugf')
        );
    }
}
