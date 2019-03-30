<?php

require __DIR__ . '/../vendor/autoload.php';

use Godbout\Alfred\Kat\Workflow;

if (getenv('action') !== 'download') {
    exit(Workflow::resultsFor(Workflow::userInput()));
}

Workflow::download();
print Workflow::notify();
