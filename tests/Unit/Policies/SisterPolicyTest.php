<?php

namespace Tests\Unit\Policies;

use App\Models\Sister;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SisterPolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_sister()
    {
        $user = $this->createUser();
        $this->assertTrue($user->can('create', new Sister));
    }

    /** @test */
    public function user_can_view_sister()
    {
        $user = $this->createUser();
        $sister = Sister::factory()->create();
        $this->assertTrue($user->can('view', $sister));
    }

    /** @test */
    public function user_can_update_sister()
    {
        $user = $this->createUser();
        $sister = Sister::factory()->create();
        $this->assertTrue($user->can('update', $sister));
    }

    /** @test */
    public function user_can_delete_sister()
    {
        $user = $this->createUser();
        $sister = Sister::factory()->create();
        $this->assertTrue($user->can('delete', $sister));
    }
}
