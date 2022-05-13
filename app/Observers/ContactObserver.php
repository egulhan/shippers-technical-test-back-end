<?php

namespace App\Observers;

use App\Models\Contact;

class ContactObserver
{
    /**
     * Handle the Contact "saving" event.
     *
     * @param \App\Models\Contact $contact
     * @return void
     */
    public function saving(Contact $contact)
    {
        // if picking a contact as primary
        if ($contact->is_primary) {
            $shipper = $contact->shipper;

            // check if there are any primary contacts for the shipper
            if (Contact::primary()->where('shipper_id', $shipper->id)->exists()) {
                Contact::primary()->where('shipper_id', $shipper->id)->update(['is_primary' => false]);
            }
        }
    }

    /**
     * Handle the Contact "created" event.
     *
     * @param \App\Models\Contact $contact
     * @return void
     */
    public function created(Contact $contact)
    {
        //
    }

    /**
     * Handle the Contact "updated" event.
     *
     * @param \App\Models\Contact $contact
     * @return void
     */
    public function updated(Contact $contact)
    {
        //
    }

    /**
     * Handle the Contact "deleted" event.
     *
     * @param \App\Models\Contact $contact
     * @return void
     */
    public function deleted(Contact $contact)
    {
        //
    }

    /**
     * Handle the Contact "restored" event.
     *
     * @param \App\Models\Contact $contact
     * @return void
     */
    public function restored(Contact $contact)
    {
        //
    }

    /**
     * Handle the Contact "force deleted" event.
     *
     * @param \App\Models\Contact $contact
     * @return void
     */
    public function forceDeleted(Contact $contact)
    {
        //
    }
}
