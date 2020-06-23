<?php

namespace Tests\Feature;

use Tests\TestCase;
use Godbout\Alfred\Kat\Workflow;

class WorkflowTest extends TestCase
{
    /** @test */
    public function it_can_search_for_torrents_on_the_kat_site()
    {
        $this->spoofUserInputInAlfredWith('fight club');

        $this->assertStringContainsString(
            'Fight Club (1999)',
            Workflow::currentMenu()
        );
    }

    /** @test */
    public function it_tells_the_user_that_there_is_no_item_found_if_well_there_is_no_item_found()
    {
        $this->spoofUserInputInAlfredWith('kjeriuhsdvfiuqherfiushvsliudfhgsidlugf');

        $this->assertStringContainsString(
            '404',
            Workflow::currentMenu()
        );
    }

    /** @test */
    public function it_can_get_the_torrent_page_link()
    {
        $this->spoofUserInputInAlfredWith('fight club');

        $this->assertStringContainsString(
            '/fight-club-1999-1080p-brrip-x264-yify-t446902.html',
            Workflow::currentMenu()
        );
    }

    /** @test */
    public function it_can_download_a_chosen_torrent_through_the_default_application()
    {
        putenv('workflow_action=download');
        putenv('torrent_page_link=/fight-club-1999-1080p-brrip-x264-yify-t446902.html');

        $this->assertTrue(
            Workflow::do()
        );
    }

    /** @test */
    public function it_can_download_a_chosen_torrent_through_a_cli_command()
    {
        putenv('workflow_action=download');
        putenv('torrent_page_link=/fight-club-1999-1080p-brrip-x264-yify-t446902.html');

        putenv('cli=: {magnet}');

        $this->assertTrue(
            Workflow::do()
        );
    }



    /** @test */
    public function it_can_copy_the_magnet_link_of_a_chosen_torrent()
    {
        putenv('workflow_action=copy');
        putenv('torrent_page_link=/fight-club-1999-1080p-brrip-x264-yify-t446902.html');

        $this->assertTrue(
            Workflow::do()
        );
    }

    /** @test */
    public function it_can_notify_the_user_when_download()
    {
        putenv('workflow_action=download');
        putenv('torrent_name=Fight Club (1999) 1080p BrRip x264 - YIFY');

        $this->assertStringContainsString(
            'Fight Club (1999) 1080p BrRip x264 - YIFY',
            Workflow::notify()
        );
    }

    /** @test */
    public function the_user_receives_the_correct_notification_according_to_its_action()
    {
        putenv('torrent_name=Fight Club (1999) 1080p BrRip x264 - YIFY');

        putenv('workflow_action=download');
        $this->assertStringContainsString(
            'will soon be at home',
            Workflow::notify()
        );

        putenv('workflow_action=copy');
        $this->assertStringContainsString(
            'has been copied to clipboard',
            Workflow::notify()
        );
    }

    /** @test */
    public function it_can_notify_the_user_when_copy()
    {
        putenv('workflow_action=copy');
        putenv('torrent_name=Fight Club (1999) 1080p BrRip x264 - YIFY');

        $this->assertStringContainsString(
            'Fight Club (1999)',
            Workflow::notify('Fight Club (1999) 1080p BrRip x264 - YIFY')
        );
    }
}
