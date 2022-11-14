<?php

namespace Tests\Unit\Policies;

use App\Models\Master;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterPolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_master()
    {
        $user = $this->createUser();
        $this->assertTrue($user->can('create', new Master));
    }

    /** @test */
    public function user_can_view_master()
    {
        $user = $this->createUser();
        $master = Master::factory()->create();
        $this->assertTrue($user->can('view', $master));
    }

    /** @test */
    public function user_can_update_master()
    {
        $user = $this->createUser();
        $master = Master::factory()->create();
        $this->assertTrue($user->can('update', $master));
    }

    /** @test */
    public function user_can_delete_master()
    {
        $user = $this->createUser();
        $master = Master::factory()->create();
        $this->assertTrue($user->can('delete', $master));
    }
}
