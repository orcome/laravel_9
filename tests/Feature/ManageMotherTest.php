<?php

namespace Tests\Feature;

use App\Models\Mother;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageMotherTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_mother_list_in_mother_index_page()
    {
        $mother = Mother::factory()->create();

        $this->loginAsUser();
        $this->visitRoute('mothers.index');
        $this->see($mother->title);
    }

    /** @test */
    public function user_can_create_a_mother()
    {
        $this->loginAsUser();
        $this->visitRoute('mothers.index');

        $this->click(__('mother.create'));
        $this->seeRouteIs('mothers.index', ['action' => 'create']);

        $this->submitForm(__('app.create'), [
            'title'       => 'Mother 1 title',
            'description' => 'Mother 1 description',
        ]);

        $this->seeRouteIs('mothers.index');

        $this->seeInDatabase('mothers', [
            'title'       => 'Mother 1 title',
            'description' => 'Mother 1 description',
        ]);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'title'       => 'Mother 1 title',
            'description' => 'Mother 1 description',
        ], $overrides);
    }

    /** @test */
    public function validate_mother_title_is_required()
    {
        $this->loginAsUser();

        // title empty
        $this->post(route('mothers.store'), $this->getCreateFields(['title' => '']));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_mother_title_is_not_more_than_60_characters()
    {
        $this->loginAsUser();

        // title 70 characters
        $this->post(route('mothers.store'), $this->getCreateFields([
            'title' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_mother_description_is_not_more_than_255_characters()
    {
        $this->loginAsUser();

        // description 256 characters
        $this->post(route('mothers.store'), $this->getCreateFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_can_edit_a_mother_within_search_query()
    {
        $this->loginAsUser();
        $mother = Mother::factory()->create(['title' => 'Testing 123']);

        $this->visitRoute('mothers.index', ['q' => '123']);
        $this->click('edit-mother-'.$mother->id);
        $this->seeRouteIs('mothers.index', ['action' => 'edit', 'id' => $mother->id, 'q' => '123']);

        $this->submitForm(__('mother.update'), [
            'title'       => 'Mother 1 title',
            'description' => 'Mother 1 description',
        ]);

        $this->seeRouteIs('mothers.index', ['q' => '123']);

        $this->seeInDatabase('mothers', [
            'title'       => 'Mother 1 title',
            'description' => 'Mother 1 description',
        ]);
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'title'       => 'Mother 1 title',
            'description' => 'Mother 1 description',
        ], $overrides);
    }

    /** @test */
    public function validate_mother_title_update_is_required()
    {
        $this->loginAsUser();
        $mother = Mother::factory()->create(['title' => 'Testing 123']);

        // title empty
        $this->patch(route('mothers.update', $mother), $this->getEditFields(['title' => '']));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_mother_title_update_is_not_more_than_60_characters()
    {
        $this->loginAsUser();
        $mother = Mother::factory()->create(['title' => 'Testing 123']);

        // title 70 characters
        $this->patch(route('mothers.update', $mother), $this->getEditFields([
            'title' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_mother_description_update_is_not_more_than_255_characters()
    {
        $this->loginAsUser();
        $mother = Mother::factory()->create(['title' => 'Testing 123']);

        // description 256 characters
        $this->patch(route('mothers.update', $mother), $this->getEditFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_can_delete_a_mother()
    {
        $this->loginAsUser();
        $mother = Mother::factory()->create();
        Mother::factory()->create();

        $this->visitRoute('mothers.index', ['action' => 'edit', 'id' => $mother->id]);
        $this->click('del-mother-'.$mother->id);
        $this->seeRouteIs('mothers.index', ['action' => 'delete', 'id' => $mother->id]);

        $this->seeInDatabase('mothers', [
            'id' => $mother->id,
        ]);

        $this->press(__('app.delete_confirm_button'));

        $this->dontSeeInDatabase('mothers', [
            'id' => $mother->id,
        ]);
    }
}
