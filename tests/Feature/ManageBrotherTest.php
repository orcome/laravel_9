<?php

namespace Tests\Feature;

use App\Models\Brother;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageBrotherTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_brother_list_in_brother_index_page()
    {
        $brother = Brother::factory()->create();

        $this->loginAsUser();
        $this->visitRoute('brothers.index');
        $this->see($brother->title);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'title'       => 'Brother 1 title',
            'description' => 'Brother 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_create_a_brother()
    {
        $this->loginAsUser();
        $this->visitRoute('brothers.index');

        $this->click(__('brother.create'));
        $this->seeRouteIs('brothers.create');

        $this->submitForm(__('app.create'), $this->getCreateFields());

        $this->seeRouteIs('brothers.show', Brother::first());

        $this->seeInDatabase('brothers', $this->getCreateFields());
    }

    /** @test */
    public function validate_brother_title_is_required()
    {
        $this->loginAsUser();

        // title empty
        $this->post(route('brothers.store'), $this->getCreateFields(['title' => '']));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_brother_title_is_not_more_than_60_characters()
    {
        $this->loginAsUser();

        // title 70 characters
        $this->post(route('brothers.store'), $this->getCreateFields([
            'title' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_brother_description_is_not_more_than_255_characters()
    {
        $this->loginAsUser();

        // description 256 characters
        $this->post(route('brothers.store'), $this->getCreateFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'title'       => 'Brother 1 title',
            'description' => 'Brother 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_edit_a_brother()
    {
        $this->loginAsUser();
        $brother = Brother::factory()->create(['title' => 'Testing 123']);

        $this->visitRoute('brothers.show', $brother);
        $this->click('edit-brother-'.$brother->id);
        $this->seeRouteIs('brothers.edit', $brother);

        $this->submitForm(__('brother.update'), $this->getEditFields());

        $this->seeRouteIs('brothers.show', $brother);

        $this->seeInDatabase('brothers', $this->getEditFields([
            'id' => $brother->id,
        ]));
    }

    /** @test */
    public function validate_brother_title_update_is_required()
    {
        $this->loginAsUser();
        $brother = Brother::factory()->create(['title' => 'Testing 123']);

        // title empty
        $this->patch(route('brothers.update', $brother), $this->getEditFields(['title' => '']));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_brother_title_update_is_not_more_than_60_characters()
    {
        $this->loginAsUser();
        $brother = Brother::factory()->create(['title' => 'Testing 123']);

        // title 70 characters
        $this->patch(route('brothers.update', $brother), $this->getEditFields([
            'title' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_brother_description_update_is_not_more_than_255_characters()
    {
        $this->loginAsUser();
        $brother = Brother::factory()->create(['title' => 'Testing 123']);

        // description 256 characters
        $this->patch(route('brothers.update', $brother), $this->getEditFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_can_delete_a_brother()
    {
        $this->loginAsUser();
        $brother = Brother::factory()->create();
        Brother::factory()->create();

        $this->visitRoute('brothers.edit', $brother);
        $this->click('del-brother-'.$brother->id);
        $this->seeRouteIs('brothers.edit', [$brother, 'action' => 'delete']);

        $this->press(__('app.delete_confirm_button'));

        $this->dontSeeInDatabase('brothers', [
            'id' => $brother->id,
        ]);
    }
}
