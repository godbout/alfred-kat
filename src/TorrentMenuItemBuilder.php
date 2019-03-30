<?php

namespace Godbout\Alfred\Kat;

use Symfony\Component\DomCrawler\Crawler;

class TorrentMenuItemBuilder
{
    public static function title(Crawler $row)
    {
        $itemMetada = [];

        $row->children('td')->nextAll()->each(function ($column) use (&$itemMetada) {
            $itemMetada[] = trim($column->text());
        });

        return trim(self::buildTitle($itemMetada));
    }

    public static function subtitle(Crawler $row)
    {
        return trim(strstr(trim($row->text()), PHP_EOL, true));
    }

    public static function pageLink(Crawler $row)
    {
        return $row->children('td a.cellMainLink')->eq(0)->attr('href');
    }

    protected static function buildTitle($metadata)
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
}
