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
        $this->assertTrue(
            Workflow::download('/fight-club-1999-1080p-brrip-x264-yify-t446902.html')
        );
    }

     /** @test */
    public function it_can_copy_the_magnet_link_of_a_chosen_torrent()
    {
        $this->markTestSkipped('This test needs to run under an osx environment');

        $this->assertTrue(
            Workflow::copy('/fight-club-1999-1080p-brrip-x264-yify-t446902.html')
        );
    }

    /** @test */
    public function it_can_notify_the_user_when_download()
    {
        $this->assertStringContainsString(
            'Fight Club (1999) 1080p BrRip x264 - YIFY',
            Workflow::notifyDownload('Fight Club (1999) 1080p BrRip x264 - YIFY')
        );
    }

    /** @test */
    public function it_can_notify_the_user_when_copy()
    {
        $this->assertStringContainsString(
            'Fight Club (1999)',
            Workflow::notifyCopy('Fight Club (1999) 1080p BrRip x264 - YIFY')
        );
    }
}
