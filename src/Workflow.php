<?php

namespace Godbout\Alfred\Kat;

use Goutte\Client;
use Godbout\Alfred\Workflow\BaseWorkflow;

class Workflow extends BaseWorkflow
{
    public static function do()
    {
        $action = getenv('action');

        if (method_exists(static::class, $action)) {
            return static::$action(getenv('torrent_page_link'));
        }

        return false;
    }

    public static function notify($result = false)
    {
        $action = getenv('action');
        $torrentName = getenv('torrent_name');

        if ($action === 'download') {
            return self::notifyDownload($torrentName);
        }

        if ($action === 'copy') {
            return self::notifyCopy($torrentName);
        }

        return 'huh. what did you do?!';
    }

    protected static function download($torrentPageLink = '')
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

    protected static function copy($torrentPageLink = '')
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

    protected static function notifyDownload($torrentName = '')
    {
        return '"' . $torrentName . '" will soon be at home!';
    }

    protected static function notifyCopy($torrentName = '')
    {
        return 'Magnet link for "' . substr($torrentName, 0, 30) . '..." has been copied to clipboard!';
    }
}
