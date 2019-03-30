<?php

namespace Tests;

use Godbout\Alfred\Kat\Workflow;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->setUpAlfredEnvVariables();
    }

    private function setUpAlfredEnvVariables()
    {
        putenv('url=https://kickasstorrents.to');
    }
}
