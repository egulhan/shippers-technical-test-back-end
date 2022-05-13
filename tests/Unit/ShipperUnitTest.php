<?php

namespace Tests\Unit;

use App\Models\Contact;
use App\Models\Shipper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShipperUnitTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test * */
    public function a_shipper_can_only_have_one_primary_contact()
    {
        $shipper = Shipper::factory()->create();
        $contact1 = Contact::factory()->for($shipper)->primary()->create();

        $this->assertDatabaseHas(Contact::class, [
            'id' => $contact1->id,
            'is_primary' => true,
        ]);

        // pick a contact on create
        $contact2 = Contact::factory()->for($shipper)->primary()->create();

        $primaryContacts = Contact::primary()->where('shipper_id', $shipper->id)->get();
        $this->assertCount(1, $primaryContacts);
        $this->assertTrue($primaryContacts[0]->id == $contact2->id);

        // pick the other contact as primary while having already a primary contact
        $contact1->refresh()->pickAsPrimary();

        $primaryContacts = Contact::primary()->where('shipper_id', $shipper->id)->get();
        $this->assertCount(1, $primaryContacts);
        $this->assertTrue($primaryContacts[0]->id == $contact1->id);
    }
}
