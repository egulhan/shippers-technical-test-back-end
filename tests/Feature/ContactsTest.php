<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\Shipper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ContactsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test * */
    public function a_user_can_add_a_contact_to_a_shipper()
    {
        $shipper = Shipper::factory()->create();
        $data = Contact::factory()->for($shipper)->make()->toArray();

        $this->postJson(route('contacts.store', $shipper->id), $data)
            ->assertSuccessful();

        $this->assertDatabaseHas(Contact::class, [
            'name' => $data['name'],
            'contact_number' => $data['contact_number'],
        ]);
    }

    /** @test * */
    public function a_user_should_get_validation_errors_on_adding_contact_to_a_shipper_if_not_providing_valid_data()
    {
        $shipper = Shipper::factory()->create();

        $jsonResponse = $this->postJson(route('contacts.store', $shipper->id), [])
            ->assertStatus(422)
            ->json();

        // check if the user gets validation error messages
        $this->assertArrayHasKey('is_primary', $jsonResponse['errors']);
        $this->assertArrayHasKey('name', $jsonResponse['errors']);
        $this->assertArrayHasKey('contact_number', $jsonResponse['errors']);
    }

    /** @test * */
    public function a_user_can_pick_a_contact_as_primary_for_a_shipper()
    {
        $shipper = Shipper::factory()->create();
        $contact = Contact::factory()->for($shipper)->create();

        $this->patch(route('contacts.pick_as_primary', ['shipper' => $shipper, 'contact' => $contact]))
            ->assertSuccessful();

        $this->assertDatabaseHas(Contact::class, [
            'id' => $contact->id,
            'shipper_id' => $shipper->id,
            'is_primary' => true,
        ]);
    }

    /** @test * */
    public function a_user_can_only_pick_a_contact_as_primary_for_its_own_shipper()
    {
        $shipper1 = Shipper::factory()->create();
        $shipper2 = Shipper::factory()->create();
        $contactForShipper2 = Contact::factory()->for($shipper2)->create();

        $this->patch(route('contacts.pick_as_primary', ['shipper' => $shipper1, 'contact' => $contactForShipper2]))
            ->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /** @test * */
    public function a_user_can_not_pick_a_contact_as_primary_which_is_already_primary_contact()
    {
        $contact = Contact::factory()->primary()->create();
        $shipper = $contact->shipper;

        $this->patchJson(route('contacts.pick_as_primary', ['shipper' => $shipper, 'contact' => $contact]))
            ->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /** @test * */
    public function a_user_can_delete_a_contact()
    {
        $contact = Contact::factory()->create();

        $this->deleteJson(route('contacts.destroy', ['shipper' => $contact->shipper, 'contact' => $contact]))
            ->assertSuccessful();

        $this->assertDatabaseCount(Contact::class, 0);
    }
}
