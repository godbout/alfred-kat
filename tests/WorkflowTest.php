<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Godbout\Alfred\Kat\Workflow;

class WorkflowTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        putenv('url=https://kickasstorrents.to');
    }

    /** @test */
    public function it_can_search_for_torrents_on_the_kat_site()
    {
        $this->assertStringContainsString(
            'Fight Club (1999)',
            Workflow::resultsFor('fight club')
        );
    }

    /** @test */
    public function it_tells_the_user_that_there_is_no_item_found_if_well_there_is_no_item_found()
    {
        $this->assertStringContainsString(
            '404',
            Workflow::resultsFor('kjeriuhsdvfiuqherfiushvsliudfhgsidlugf')
        );
    }

    /** @test */
    public function it_can_get_the_torrent_page_link()
    {
        $this->assertStringContainsString(
            '/fight-club-1999-1080p-brrip-x264-yify-t446902.html',
            Workflow::resultsFor('fight club')
        );
    }
}
