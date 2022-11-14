<?php

namespace Tests\Feature;

use App\Models\Master;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageMasterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_master_list_in_master_index_page()
    {
        $master = Master::factory()->create();

        $this->loginAsUser();
        $this->visitRoute('masters.index');
        $this->see($master->title);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'title' => 'Master 1 title',
            'description' => 'Master 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_create_a_master()
    {
        $this->loginAsUser();
        $this->visitRoute('masters.index');

        $this->click(__('master.create'));
        $this->seeRouteIs('masters.create');

        $this->submitForm(__('app.create'), $this->getCreateFields());

        $this->seeRouteIs('masters.show', Master::first());

        $this->seeInDatabase('masters', $this->getCreateFields());
    }

    /** @test */
    public function validate_master_title_is_required()
    {
        $this->loginAsUser();

        // title empty
        $this->post(route('masters.store'), $this->getCreateFields(['title' => '']));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_master_title_is_not_more_than_60_characters()
    {
        $this->loginAsUser();

        // title 70 characters
        $this->post(route('masters.store'), $this->getCreateFields([
            'title' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_master_description_is_not_more_than_255_characters()
    {
        $this->loginAsUser();

        // description 256 characters
        $this->post(route('masters.store'), $this->getCreateFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'title' => 'Master 1 title',
            'description' => 'Master 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_edit_a_master()
    {
        $this->loginAsUser();
        $master = Master::factory()->create(['title' => 'Testing 123']);

        $this->visitRoute('masters.show', $master);
        $this->click('edit-master-'.$master->id);
        $this->seeRouteIs('masters.edit', $master);

        $this->submitForm(__('master.update'), $this->getEditFields());

        $this->seeRouteIs('masters.show', $master);

        $this->seeInDatabase('masters', $this->getEditFields([
            'id' => $master->id,
        ]));
    }

    /** @test */
    public function validate_master_title_update_is_required()
    {
        $this->loginAsUser();
        $master = Master::factory()->create(['title' => 'Testing 123']);

        // title empty
        $this->patch(route('masters.update', $master), $this->getEditFields(['title' => '']));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_master_title_update_is_not_more_than_60_characters()
    {
        $this->loginAsUser();
        $master = Master::factory()->create(['title' => 'Testing 123']);

        // title 70 characters
        $this->patch(route('masters.update', $master), $this->getEditFields([
            'title' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_master_description_update_is_not_more_than_255_characters()
    {
        $this->loginAsUser();
        $master = Master::factory()->create(['title' => 'Testing 123']);

        // description 256 characters
        $this->patch(route('masters.update', $master), $this->getEditFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_can_delete_a_master()
    {
        $this->loginAsUser();
        $master = Master::factory()->create();
        Master::factory()->create();

        $this->visitRoute('masters.edit', $master);
        $this->click('del-master-'.$master->id);
        $this->seeRouteIs('masters.edit', [$master, 'action' => 'delete']);

        $this->press(__('app.delete_confirm_button'));

        $this->dontSeeInDatabase('masters', [
            'id' => $master->id,
        ]);
    }
}
