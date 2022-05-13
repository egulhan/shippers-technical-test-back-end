<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\Shipper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShippersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test * */
    public function a_user_can_create_a_shipper()
    {
        $data = Shipper::factory()->make()->toArray();

        $this->postJson(route('shippers.store'), $data)
            ->assertSuccessful();

        $this->assertDatabaseHas(Shipper::class, [
            'company_name' => $data['company_name'],
            'address' => $data['address'],
        ]);
    }

    /** @test * */
    public function a_user_should_get_validation_errors_on_create_if_not_providing_valid_data()
    {
        $jsonResponse = $this->postJson(route('shippers.store'), [])
            ->assertStatus(422)
            ->json();

        // check if the user gets validation error messages
        $this->assertArrayHasKey('company_name', $jsonResponse['errors']);
        $this->assertArrayHasKey('address', $jsonResponse['errors']);
    }

    /** @test * */
    public function a_user_can_update_a_shipper_record()
    {
        $shipper = Shipper::factory()->create();
        $newCompanyName = 'Test123';
        $shipper->company_name = $newCompanyName;

        $data = $shipper->toArray();

        $this->patch(route('shippers.update', $shipper->id), $data)
            ->assertSuccessful();

        $this->assertDatabaseHas(Shipper::class, [
            'id' => $shipper->id,
            'company_name' => $newCompanyName,
        ]);
    }

    /** @test * */
    public function a_user_can_list_shippers()
    {
        Shipper::factory()->count(5)->create();

        $this->getJson(route('shippers.index'))
            ->assertSuccessful()
            ->assertJsonCount(5, 'data');
    }

    /** @test * */
    public function a_user_should_see_primary_contacts_of_shippers_when_listing_shippers()
    {
        Contact::factory()->primary()->count(3)->create();

        $this->getJson(route('shippers.index'))
            ->assertSuccessful()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure(['data' => [
                '*' => [
                    'primary_contact',
                ],
            ]]);
    }

    /** @test * */
    public function a_user_can_list_contacts_of_a_shipper()
    {
        $shipper = Shipper::factory()->create();
        Contact::factory()->for($shipper)->count(7)->create();

        $this->getJson(route('shippers.list_contacts', $shipper))
            ->assertSuccessful()
            ->assertJsonCount(7, 'data.contacts');
    }
}
