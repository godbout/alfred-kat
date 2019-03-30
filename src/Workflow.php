<?php

namespace Godbout\Alfred\Kat;

use Godbout\Alfred\Kat\Menu;
use Godbout\Alfred\Workflow\Icon;
use Godbout\Alfred\Workflow\Item;
use Godbout\Alfred\Workflow\ScriptFilter;
use Goutte\Client;

class Workflow
{
    public static function resultsFor($term = '')
    {
        $torrents = self::searchOnlineFor($term);

        self::buildMenuFor($torrents);

        return ScriptFilter::output();
    }

    protected static function buildMenuFor($torrents)
    {
        if ($torrents->count()) {
            $torrents->nextAll()->each(function ($row) {
                ScriptFilter::add(
                    Item::create()
                        ->title(Menu::itemTitle($row))
                        ->subtitle(Menu::itemSubtitle($row))
                        ->icon(Icon::create("resources/icons/magnet.png"))
                        ->arg('download')
                        ->variable('torrent_page_link', Menu::itemPageLink($row))
                        ->variable('torrent_name', Menu::itemSubtitle($row))
                );
            });
        } else {
            ScriptFilter::add(
                Item::create()
                    ->title('404 for ' . self::userInput() . ' ☹️')
                    ->subtitle('Try some other terms maybe?')
            );
        }
    }

    protected static function searchOnlineFor($term)
    {
        $crawler = (new Client())->request('GET', getenv('url') . '/usearch/' . urlencode($term));

        return $crawler->filter('.frontPageWidget tr');
    }

    public static function userInput()
    {
        global $argv;

        return trim($argv[1] ?? '');
    }

    public static function download()
    {
        $client = new Client();

        $crawler = $client->request('GET', getenv('url') . getenv('torrent_page_link'));

        $magnetLink = $crawler->filter('a[title="Magnet link"]')->attr('href');

        return shell_exec("open $magnetLink");
    }

    public static function notify()
    {
        return '"' . getenv('torrent_name') .'" will soon be at home!';
    }
}
