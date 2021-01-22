<?php

namespace Tests\Feature;

use Tests\TestCase;
use Godbout\Alfred\Kat\Workflow;

class TagsTest extends TestCase
{
    /** @test */
    public function it_can_filter_torrents_by_music_type()
    {
        $this->spoofUserInputInAlfredWith('blonde redhead #music');

        $this->assertStringContainsString(
            'Blonde Redhead 2007 23',
            Workflow::currentMenu()
        );

        $this->assertStringNotContainsString(
            'Porno',
            Workflow::currentMenu()
        );
    }
}
