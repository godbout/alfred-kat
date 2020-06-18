<?php

namespace Tests\Unit;

use Tests\TestCase;
use Godbout\Alfred\Kat\Workflow;

class WorkflowTest extends TestCase
{
    /** @test */
    public function calling_a_workflow_action_that_does_not_exists_returns_false()
    {
        putenv('workflow_action=LOOOLLLOLL');

        $this->assertFalse(Workflow::do());
    }

    /** @test */
    public function calling_a_workflow_action_that_does_not_exists_sends_a_notification_that_huh_you_wrong()
    {
        putenv('workflow_action=LOOOLLLOLL');

        $this->assertStringContainsString(
            'huh.',
            Workflow::notify()
        );
    }
}
