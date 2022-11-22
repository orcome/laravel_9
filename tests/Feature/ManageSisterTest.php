<?php

namespace Tests\Feature;

use App\Models\Sister;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageSisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_sister_list_in_sister_index_page()
    {
        $sister = Sister::factory()->create();

        $this->loginAsUser();
        $this->visitRoute('sisters.index');
        $this->see($sister->title);
    }

    /** @test */
    public function user_can_create_a_sister()
    {
        $this->loginAsUser();
        $this->visitRoute('sisters.index');

        $this->click(__('sister.create'));
        $this->seeRouteIs('sisters.index', ['action' => 'create']);

        $this->submitForm(__('app.create'), [
            'title'       => 'Sister 1 title',
            'description' => 'Sister 1 description',
        ]);

        $this->seeRouteIs('sisters.index');

        $this->seeInDatabase('sisters', [
            'title'       => 'Sister 1 title',
            'description' => 'Sister 1 description',
        ]);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'title'       => 'Sister 1 title',
            'description' => 'Sister 1 description',
        ], $overrides);
    }

    /** @test */
    public function validate_sister_title_is_required()
    {
        $this->loginAsUser();

        // title empty
        $this->post(route('sisters.store'), $this->getCreateFields(['title' => '']));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_sister_title_is_not_more_than_60_characters()
    {
        $this->loginAsUser();

        // title 70 characters
        $this->post(route('sisters.store'), $this->getCreateFields([
            'title' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_sister_description_is_not_more_than_255_characters()
    {
        $this->loginAsUser();

        // description 256 characters
        $this->post(route('sisters.store'), $this->getCreateFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_can_edit_a_sister_within_search_query()
    {
        $this->loginAsUser();
        $sister = Sister::factory()->create(['title' => 'Testing 123']);

        $this->visitRoute('sisters.index', ['q' => '123']);
        $this->click('edit-sister-'.$sister->id);
        $this->seeRouteIs('sisters.index', ['action' => 'edit', 'id' => $sister->id, 'q' => '123']);

        $this->submitForm(__('sister.update'), [
            'title'       => 'Sister 1 title',
            'description' => 'Sister 1 description',
        ]);

        $this->seeRouteIs('sisters.index', ['q' => '123']);

        $this->seeInDatabase('sisters', [
            'title'       => 'Sister 1 title',
            'description' => 'Sister 1 description',
        ]);
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'title'       => 'Sister 1 title',
            'description' => 'Sister 1 description',
        ], $overrides);
    }

    /** @test */
    public function validate_sister_title_update_is_required()
    {
        $this->loginAsUser();
        $sister = Sister::factory()->create(['title' => 'Testing 123']);

        // title empty
        $this->patch(route('sisters.update', $sister), $this->getEditFields(['title' => '']));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_sister_title_update_is_not_more_than_60_characters()
    {
        $this->loginAsUser();
        $sister = Sister::factory()->create(['title' => 'Testing 123']);

        // title 70 characters
        $this->patch(route('sisters.update', $sister), $this->getEditFields([
            'title' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_sister_description_update_is_not_more_than_255_characters()
    {
        $this->loginAsUser();
        $sister = Sister::factory()->create(['title' => 'Testing 123']);

        // description 256 characters
        $this->patch(route('sisters.update', $sister), $this->getEditFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_can_delete_a_sister()
    {
        $this->loginAsUser();
        $sister = Sister::factory()->create();
        Sister::factory()->create();

        $this->visitRoute('sisters.index', ['action' => 'edit', 'id' => $sister->id]);
        $this->click('del-sister-'.$sister->id);
        $this->seeRouteIs('sisters.index', ['action' => 'delete', 'id' => $sister->id]);

        $this->seeInDatabase('sisters', [
            'id' => $sister->id,
        ]);

        $this->press(__('app.delete_confirm_button'));

        $this->dontSeeInDatabase('sisters', [
            'id' => $sister->id,
        ]);
    }
}
