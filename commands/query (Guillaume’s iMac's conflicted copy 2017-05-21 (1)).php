<?php

require 'vendor/autoload.php';

use Alfred\Workflows\Workflow;

$baseUrl = getenv('baseUrl');
$query = trim($argv[1]);
$fullUrl = $baseUrl . $query;

$workflow = new Workflow;

$ch = curl_init($fullUrl);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

if ($response === false) {
    $workflow->result()
        ->title('Cannot connect to KAT server, server might be down')
        ->subtitle('Try a mirror. URL is changeable in the Workflow Environment Variables.')
        ->valid(false);
} else {
    $dom = new IvoPetkov\HTML5DOMDocument();
    $dom->loadHTML($response);
    $rows = $dom->querySelector('table.data')->querySelectorAll('tr.odd');
    date_default_timezone_set('America/Los_Angeles');
    foreach ($rows as $row) {
        $html = $row->innerHTML;

        preg_match_all('/class="cellMainLink">(.*?)<\/a>/s', $html, $title);
        preg_match_all('/class="center" title="(.*?)">(.*?)<\/td>/s', $html, $date);
        preg_match_all('/<td class="nobr center">(.*?)<\/td>/s', $html, $size);
        preg_match_all('/class="green center">(.*?)<\/td>/s', $html, $seeders);
        preg_match_all('/class="red lasttd center">(.*)<\/td>/s', $html, $leechers);
        preg_match_all('/<a data-nop title="Torrent magnet link" href="(.*?)"/s', $html, $magnet);

        /**
         * For a strange reason, html_entity_decode decodes correctly
         * but the string is not usable in createFormFormat which
         * returns FALSE, so have to use str_replace.
         */
        
        /**
         * Try to get a readable date format
         * but the format keeps changing.
         * So if we can't get a correct one, just show
         * the one we receive from the html
         */
        // $readableDate = trim(str_replace('&nbsp;', ' ', $date[1][0]));
        // var_dump($readableDate);

        // $date = DateTime::createFromFormat('m-d Y', $date);

        // if ($date === true) {
        //     $readableDate = $date->format('M d, Y');
        // } else {
        //     $date = DateTime::createFromFormat('m-d H:i', trim(str_replace('&nbsp;', ' ', $date[1][0])));
        //     if ($date === true) {
        //         $readableDate = $date->format('M d, Y');
        //     }
        // }

        $subtitle = $readableDate . ', ' . trim(html_entity_decode($size[1][0])) . ', seeders: ' . trim($seeders[1][0]) . ', leechers: ' . trim($leechers[1][0]);

        $workflow->result()
            ->title($title[1][0])
            ->arg($magnet[1][0])
            ->subtitle($subtitle)
            ->icon('icons/magnet.png');
    }

    if (count($rows) === 0) {
    $workflow->result()
            ->title('No Items Found')
            ->subtitle('Search for another term maybe?')
    }
}

echo $workflow->output();
