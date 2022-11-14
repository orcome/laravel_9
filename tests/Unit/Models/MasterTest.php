<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Master;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_master_has_title_link_attribute()
    {
        $master = Master::factory()->create();

        $title = __('app.show_detail_title', [
            'title' => $master->title, 'type' => __('master.master'),
        ]);
        $link = '<a href="'.route('masters.show', $master).'"';
        $link .= ' title="'.$title.'">';
        $link .= $master->title;
        $link .= '</a>';

        $this->assertEquals($link, $master->title_link);
    }

    /** @test */
    public function a_master_has_belongs_to_creator_relation()
    {
        $master = Master::factory()->make();

        $this->assertInstanceOf(User::class, $master->creator);
        $this->assertEquals($master->creator_id, $master->creator->id);
    }
}
