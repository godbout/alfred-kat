<?php

namespace Godbout\Alfred\Kat;

use Goutte\Client;
use Godbout\Alfred\Workflow\Icon;
use Godbout\Alfred\Workflow\Item;
use Godbout\Alfred\Workflow\Mods\Cmd;
use Godbout\Alfred\Workflow\ScriptFilter;
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

    public static function download($torrentPageLink = '')
    {
        $magnetLink = self::findMagnetLinkOn($torrentPageLink);

        if (getenv('cli') !== false) {
            return self::downloadThroughCliCommand($magnetLink);
        }

        return self::downloadThroughDefaultApplication($magnetLink);
    }

    protected static function downloadThroughCliCommand($magnetLink = '')
    {
        system(str_replace('{magnet}', $magnetLink, getenv('cli')), $result);

        return $result === 0;
    }

    protected static function downloadThroughDefaultApplication($magnetLink = '')
    {
        system("open $magnetLink 2>&1", $result);

        return $result === 0;
    }

    public static function copy($torrentPageLink = '')
    {
        $magnetLink = self::findMagnetLinkOn($torrentPageLink);

        system("echo '$magnetLink' | pbcopy 2>&1", $result);

        return $result === 0;
    }

    protected static function findMagnetLinkOn($torrentPageLink = '')
    {
        $crawler = (new Client())->request('GET', getenv('url') . $torrentPageLink);

        return $crawler->filter('#tab-technical a.siteButton.giantButton')->attr('href');
    }

    public static function notifyDownload($torrentName = '')
    {
        return '"' . $torrentName . '" will soon be at home!';
    }

    public static function notifyCopy($torrentName = '')
    {
        return 'Magnet link for "' . substr($torrentName, 0, 30) . '..." has been copied to clipboard!';
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
                        ->mod(
                            Cmd::create()
                                ->arg('copy')
                                ->subtitle('Copy magnet link')
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
