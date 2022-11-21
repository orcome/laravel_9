<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Mother;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MotherTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_mother_has_title_link_attribute()
    {
        $mother = Mother::factory()->create();

        $title = __('app.show_detail_title', [
            'title' => $mother->title, 'type' => __('mother.mother'),
        ]);
        $link = '<a href="'.route('mothers.show', $mother).'"';
        $link .= ' title="'.$title.'">';
        $link .= $mother->title;
        $link .= '</a>';

        $this->assertEquals($link, $mother->title_link);
    }

    /** @test */
    public function a_mother_has_belongs_to_creator_relation()
    {
        $mother = Mother::factory()->make();

        $this->assertInstanceOf(User::class, $mother->creator);
        $this->assertEquals($mother->creator_id, $mother->creator->id);
    }
}
