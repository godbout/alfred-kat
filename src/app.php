<?php

require __DIR__ . '/../vendor/autoload.php';

use Godbout\Alfred\Kat\Workflow;

if (getenv('next') === 'do') {
    print Workflow::notify(Workflow::do());

    return;
}

print Workflow::currentMenu();
