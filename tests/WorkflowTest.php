<?php

namespace Tests;

use Godbout\Alfred\Kat\Workflow;

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

    /** @test */
    public function it_can_download_a_chosen_torrent()
    {
        $this->assertEmpty(
            Workflow::download('/fight-club-1999-1080p-brrip-x264-yify-t446902.html')
        );
    }

    /** @test */
    public function it_can_notify_the_user()
    {
        $this->assertStringContainsString(
            'Fight Club (1999) 1080p BrRip x264 - YIFY',
            Workflow::notify('Fight Club (1999) 1080p BrRip x264 - YIFY')
        );
    }
}
