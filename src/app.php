<?php

require __DIR__ . '/../vendor/autoload.php';

use Godbout\Alfred\Kat\Workflow;

if (getenv('action') === 'do') {
    $result = Workflow::do();
    print Workflow::notify($result);
} else {
    print Workflow::resultsFor(Workflow::userInput());
}
