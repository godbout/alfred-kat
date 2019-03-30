<?php

namespace Godbout\Alfred\Kat;

use Godbout\Alfred\Workflow\Icon;
use Godbout\Alfred\Workflow\Item;
use Godbout\Alfred\Workflow\ScriptFilter;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class Workflow
{
    public static function action()
    {
        return getenv('action');
    }

    public static function userInput()
    {
        global $argv;

        return trim($argv[1] ?? '');
    }

    public static function resultsFor($term = '')
    {
        $torrents = self::searchOnlineFor($term);

        return self::menuFor($torrents);
    }

    public static function download($magnetLink = '')
    {
        $crawler = (new Client())->request('GET', getenv('url') . $magnetLink);

        $magnetLink = $crawler->filter('a[title="Magnet link"]')->attr('href');

        return exec("open $magnetLink 2>&1", $result);
    }

    public static function notify($torrentName = '')
    {
        return '"' . $torrentName . '" will soon be at home!';
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
                        ->arg('download')
                        ->variable('torrent_page_link', TorrentMenuItemBuilder::pageLink($row))
                        ->variable('torrent_name', TorrentMenuItemBuilder::subtitle($row))
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
