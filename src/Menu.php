<?php

namespace Godbout\Alfred\Kat;

class Menu
{
    public static function itemTitle($row)
    {
        $itemMetada = [];

        $row->children('td')->nextAll()->each(function ($column) use (&$itemMetada) {
            $itemMetada[] = trim($column->text());
        });

        return trim(self::buildItemTitle($itemMetada));
    }

    public static function itemSubtitle($row)
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

    public static function itemPageLink($row)
    {
        return $row->children('td a.cellMainLink')->eq(0)->attr('href');
    }
}
