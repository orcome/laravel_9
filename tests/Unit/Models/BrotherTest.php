<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Brother;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrotherTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_brother_has_title_link_attribute()
    {
        $brother = Brother::factory()->create();

        $this->assertEquals(
            link_to_route('brothers.show', $brother->title, [$brother], [
                'title' => __(
                    'app.show_detail_title',
                    ['title' => $brother->title, 'type' => __('brother.brother')]
                ),
            ]), $brother->title_link
        );
    }

    /** @test */
    public function a_brother_has_belongs_to_creator_relation()
    {
        $brother = Brother::factory()->make();

        $this->assertInstanceOf(User::class, $brother->creator);
        $this->assertEquals($brother->creator_id, $brother->creator->id);
    }
}
