<?php

namespace Tests\Unit;

use Tests\TestCase;
use Godbout\Alfred\Kat\Workflow;

class WorkflowTest extends TestCase
{
    /** @test */
    public function it_can_get_the_action_env_variable()
    {
        putenv('action=copy');

        $this->assertSame(
            'copy',
            Workflow::action()
        );
    }
}
