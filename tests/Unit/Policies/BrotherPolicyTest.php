<?php

namespace Tests\Unit\Policies;

use App\Models\Brother;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrotherPolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_brother()
    {
        $user = $this->createUser();
        $this->assertTrue($user->can('create', new Brother));
    }

    /** @test */
    public function user_can_view_brother()
    {
        $user = $this->createUser();
        $brother = Brother::factory()->create();
        $this->assertTrue($user->can('view', $brother));
    }

    /** @test */
    public function user_can_update_brother()
    {
        $user = $this->createUser();
        $brother = Brother::factory()->create();
        $this->assertTrue($user->can('update', $brother));
    }

    /** @test */
    public function user_can_delete_brother()
    {
        $user = $this->createUser();
        $brother = Brother::factory()->create();
        $this->assertTrue($user->can('delete', $brother));
    }
}
