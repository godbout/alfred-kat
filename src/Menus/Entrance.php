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

    protected static function resultsFor($userInput = '')
    {
        $torrents = self::searchOnlineFor($userInput);

        return self::menuFor($torrents);
    }

    protected static function searchOnlineFor($userInput)
    {
        $crawler = (new Client())->request('GET', self::buildURLFrom($userInput));

        return $crawler->filter('.frontPageWidget tr');
    }

    protected static function buildURLFrom($userInput)
    {
        if (($tag = strstr($userInput, '#')) !== false) {
            $term = strstr($userInput, '#', true);

            return getenv('url') . '/search/' . urlencode($term) . '/category/' . ltrim($tag, '#') . '/';
        }

        return getenv('url') . '/usearch/' . urlencode($userInput);
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
                        ->variable('action', 'download')
                        ->variable('torrent_page_link', TorrentMenuItemBuilder::pageLink($row))
                        ->variable('torrent_name', TorrentMenuItemBuilder::subtitle($row))
                        ->mod(
                            Cmd::create()
                                ->arg('do')
                                ->subtitle('Copy magnet link')
                                ->variable('action', 'copy')
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
