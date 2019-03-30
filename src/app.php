<?php

require __DIR__ . '/../vendor/autoload.php';

use Godbout\Alfred\Kat\Workflow;

if (Workflow::action() === 'download') {
    Workflow::download();
    exit(Workflow::notify());
}

print Workflow::resultsFor(Workflow::userInput());
