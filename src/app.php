<?php

require __DIR__ . '/../vendor/autoload.php';

use Godbout\Alfred\Kat\Workflow;

if (getenv('action') === 'do') {
    print Workflow::notify(Workflow::do());

    return;
}

print Workflow::currentMenu();
