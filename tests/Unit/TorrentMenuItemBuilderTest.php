<?php

namespace Tests;

use Goutte\Client;
use Godbout\Alfred\Kat\TorrentMenuItemBuilder;

class TorrentMenuItemBuilderTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->row = (new Client())
            ->request('GET', getenv('url') . '/usearch/ponyo')
            ->filter('.frontPageWidget tr')
            ->nextAll()
            ->eq(0);
    }

    /** @test */
    public function it_can_build_the_item_title()
    {
        $this->assertStringContainsString(
            'ago by YTSAGx, 1.7 GB',
            TorrentMenuItemBuilder::title($this->row)
        );
    }

    /** @test */
    public function it_can_build_the_item_subtitle()
    {
        $this->assertSame(
            'Ponyo (2008) BluRay 1080p YTS YIFY',
            TorrentMenuItemBuilder::subtitle($this->row)
        );
    }

    /** @test */
    public function it_can_build_the_page_link()
    {
        $this->assertSame(
            '/ponyo-2008-bluray-1080p-yts-yify-t3657848.html',
            TorrentMenuItemBuilder::pageLink($this->row)
        );
    }
}
