<?php

namespace Tests\Unit\Policies;

use App\Models\Mother;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MotherPolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_mother()
    {
        $user = $this->createUser();
        $this->assertTrue($user->can('create', new Mother));
    }

    /** @test */
    public function user_can_view_mother()
    {
        $user = $this->createUser();
        $mother = Mother::factory()->create();
        $this->assertTrue($user->can('view', $mother));
    }

    /** @test */
    public function user_can_update_mother()
    {
        $user = $this->createUser();
        $mother = Mother::factory()->create();
        $this->assertTrue($user->can('update', $mother));
    }

    /** @test */
    public function user_can_delete_mother()
    {
        $user = $this->createUser();
        $mother = Mother::factory()->create();
        $this->assertTrue($user->can('delete', $mother));
    }
}
