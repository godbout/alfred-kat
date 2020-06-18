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

    protected function setUpAlfredEnvVariables()
    {
        putenv('url=https://kickasstorrents.to');
    }

    protected function spoofUserInputInAlfredWith($userInput = 'bullshit')
    {
        global $argv;

        $argv[1] = $userInput;
    }
}
