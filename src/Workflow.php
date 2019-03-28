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

        $crawler->filter('.firstr')->nextAll()->each(function ($row) {
            ScriptFilter::add(
                Item::create()
                    ->title(trim(self::itemTitle($row)))
                    ->subtitle(trim($row->text()))
                    ->icon(Icon::create("resources/icons/magnet.png"))
            );
        });

        return ScriptFilter::output();
    }

    public static function itemTitle($row)
    {
        $itemMetada = [];

        $row->children('td')->nextAll()->each(function ($column) use (&$itemMetada) {
            $itemMetada[] = trim($column->text());
        });

        return self::buildItemTitle($itemMetada);
    }

    public static function buildItemTitle($metadata)
    {
        [$timeagoNumericPart, $timeagoAlphaPart] = self::buildTimeagoValue($metadata[2]);

        return "$timeagoNumericPart $timeagoAlphaPart ago by $metadata[1], $metadata[0], $metadata[3] seeders ($metadata[4] l)";
    }

    public static function buildTimeagoValue($timeago)
    {
        $numbericPart = intval($timeago);

        $alphaPart = str_replace($numbericPart, '', $timeago);

        return [$numbericPart, $alphaPart];
    }

    public static function userInput()
    {
        global $argv;

        return trim($argv[1] ?? '');
    }
}
