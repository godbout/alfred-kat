<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpAlfredEnvVariables();
    }

    private function setUpAlfredEnvVariables()
    {
        putenv('url=https://kickasstorrents.to');
    }
}
