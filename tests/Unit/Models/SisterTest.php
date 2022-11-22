<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Sister;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_sister_has_title_link_attribute()
    {
        $sister = Sister::factory()->create();

        $this->assertEquals(
            link_to_route('sisters.show', $sister->title, [$sister], [
                'title' => __(
                    'app.show_detail_title',
                    ['title' => $sister->title, 'type' => __('sister.sister')]
                ),
            ]), $sister->title_link
        );
    }

    /** @test */
    public function a_sister_has_belongs_to_creator_relation()
    {
        $sister = Sister::factory()->make();

        $this->assertInstanceOf(User::class, $sister->creator);
        $this->assertEquals($sister->creator_id, $sister->creator->id);
    }
}
