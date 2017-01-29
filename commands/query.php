<?php

require 'vendor/autoload.php';

use Alfred\Workflows\Workflow;

$baseUrl = getenv('baseUrl');
$query = trim($argv[1]);
$fullUrl = $baseUrl . $query;

$ch = curl_init($fullUrl);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$workflow = new Workflow;

$dom = new IvoPetkov\HTML5DOMDocument();
$dom->loadHTML($response);
$rows = $dom->querySelector('table.data')->querySelectorAll('tr.odd');
foreach ($rows as $row) {
    preg_match_all('/class="cellMainLink">(.*?)<\/a>/s', $row->innerHTML, $title);
    preg_match_all('/class="center" title="(.*?)">(.*?)<\/td>/s', $row->innerHTML, $date);
    preg_match_all('/<td class="nobr center">(.*?)<\/td>/s', $row->innerHTML, $size);
    preg_match_all('/class="green center">(.*?)<\/td>/s', $row->innerHTML, $seeders);
    preg_match_all('/class="red lasttd center">(.*)<\/td>/s', $row->innerHTML, $leechers);
    preg_match_all('/<a data-nop title="Torrent magnet link" href="(.*?)"/s', $row->innerHTML, $magnet);

    $subtitle = trim(html_entity_decode($date[1][0])) . ', ' . trim(html_entity_decode($size[1][0])) . ', seeders: ' . trim($seeders[1][0]) . ', leechers: ' . trim($leechers[1][0]);

    $workflow->result()
        ->title($title[1][0])
        ->arg($magnet[1][0])
        ->subtitle($subtitle);
}

echo $workflow->output();
