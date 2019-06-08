<?php

require __DIR__ . '/../vendor/autoload.php';

use Godbout\Alfred\Kat\Workflow;

if (Workflow::action() === 'download') {
    Workflow::download(getenv('torrent_page_link'));
    exit(Workflow::notifyDownload(getenv('torrent_name')));
}

if (Workflow::action() === 'copy') {
    Workflow::copy(getenv('torrent_page_link'));
    exit(Workflow::notifyCopy(getenv('torrent_name')));
}

print Workflow::resultsFor(Workflow::userInput());
