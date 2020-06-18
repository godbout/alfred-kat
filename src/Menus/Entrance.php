<?php

namespace Godbout\Alfred\Kat\Menus;

use Goutte\Client;
use Godbout\Alfred\Workflow\Icon;
use Godbout\Alfred\Workflow\Item;
use Godbout\Alfred\Workflow\Mods\Cmd;
use Godbout\Alfred\Workflow\ScriptFilter;
use Symfony\Component\DomCrawler\Crawler;
use Godbout\Alfred\Workflow\Menus\BaseMenu;
use Godbout\Alfred\Kat\TorrentMenuItemBuilder;

class Entrance extends BaseMenu
{
    public static function scriptFilter()
    {
        ScriptFilter::add(
            self::resultsFor(self::userInput())
        );
    }

    protected static function resultsFor($term = '')
    {
        $torrents = self::searchOnlineFor($term);

        return self::menuFor($torrents);
    }

    protected static function searchOnlineFor($term)
    {
        $crawler = (new Client())->request('GET', getenv('url') . '/usearch/' . urlencode($term));

        return $crawler->filter('.frontPageWidget tr');
    }

    protected static function menuFor(Crawler $torrents)
    {
        if ($torrents->count()) {
            $torrents->nextAll()->each(function ($row) {
                ScriptFilter::add(
                    Item::create()
                        ->title(TorrentMenuItemBuilder::title($row))
                        ->subtitle(TorrentMenuItemBuilder::subtitle($row))
                        ->icon(Icon::create("resources/icons/magnet.png"))
                        ->arg('do')
                        ->variable('workflow_action', 'download')
                        ->variable('torrent_page_link', TorrentMenuItemBuilder::pageLink($row))
                        ->variable('torrent_name', TorrentMenuItemBuilder::subtitle($row))
                        ->mod(
                            Cmd::create()
                                ->arg('do')
                                ->subtitle('Copy magnet link')
                                ->variable('workflow_action', 'copy')
                                ->variable('torrent_page_link', TorrentMenuItemBuilder::pageLink($row))
                                ->variable('torrent_name', TorrentMenuItemBuilder::subtitle($row))
                        )
                );
            });
        } else {
            ScriptFilter::add(
                Item::create()
                    ->title('404 for ' . self::userInput() . ' ☹️')
                    ->subtitle('Try some other terms maybe?')
            );
        }

        return ScriptFilter::output();
    }
}
