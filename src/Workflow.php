<?php

namespace Godbout\Alfred\Kat;

use Goutte\Client;
use Godbout\Alfred\Workflow\Icon;
use Godbout\Alfred\Workflow\Item;
use Godbout\Alfred\Workflow\ScriptFilter;

class Workflow
{
    public static function resultsFor($term = '')
    {
        $client = new Client();

        $crawler = $client->request('GET', getenv('url') . urlencode($term));

        $torrentsRows = $crawler->filter('.frontPageWidget tr');

        if ($torrentsRows->count()) {
            $torrentsRows->nextAll()->each(function ($row) {
                ScriptFilter::add(
                    Item::create()
                        ->title(self::itemTitle($row))
                        ->subtitle(self::itemSubtitle($row))
                        ->icon(Icon::create("resources/icons/magnet.png"))
                        ->arg('download')
                        ->variable('torrent_page_link', self::itemPageLink($row))
                );
            });
        } else {
            ScriptFilter::add(
                Item::create()
                    ->title('not found')
            );
        }

        return ScriptFilter::output();
    }

    protected static function itemTitle($row)
    {
        $itemMetada = [];

        $row->children('td')->nextAll()->each(function ($column) use (&$itemMetada) {
            $itemMetada[] = trim($column->text());
        });

        return trim(self::buildItemTitle($itemMetada));
    }

    protected static function itemSubtitle($row)
    {
        return trim(strstr(trim($row->text()), PHP_EOL, true));
    }

    protected static function buildItemTitle($metadata)
    {
        [$timeagoNumericPart, $timeagoAlphaPart] = self::buildTimeagoValue($metadata[2]);

        return "$timeagoNumericPart $timeagoAlphaPart ago by $metadata[1], $metadata[0], $metadata[3] seeders ($metadata[4] l)";
    }

    protected static function buildTimeagoValue($timeago)
    {
        $numbericPart = intval($timeago);

        $alphaPart = str_replace($numbericPart, '', $timeago);

        return [$numbericPart, $alphaPart];
    }

    protected static function itemPageLink($row)
    {
        return $row->children('td a.cellMainLink')->eq(0)->attr('href');
    }

    public static function userInput()
    {
        global $argv;

        return trim($argv[1] ?? '');
    }
}
