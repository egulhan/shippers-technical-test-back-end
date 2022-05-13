<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Models\Shipper;
use Illuminate\Http\Response;

class ContactsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return ContactResource
     */
    public function store(StoreContactRequest $request, Shipper $shipper)
    {
        $contact = new Contact([
            'is_primary' => $request->is_primary,
            'name' => $request->name,
            'contact_number' => $request->contact_number,
        ]);

        $contact
            ->shipper()->associate($shipper)
            ->save();

        return new ContactResource($contact);
    }

    /**
     * Pick a contact as primary for a shipper.
     *
     * @return ContactResource|\Illuminate\Http\JsonResponse
     */
    public function pickAsPrimary(Shipper $shipper, Contact $contact)
    {
        if ($contact->shipper_id !== $shipper->id) {
            return response()->json([
                'message' => 'You can only pick a contact as primary for its own shipper!',
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($contact->is_primary) {
            return response()->json([
                'message' => 'You can not pick a contact as primary which is already primary!',
            ], Response::HTTP_BAD_REQUEST);
        }

        $contact->pickAsPrimary();

        return new ContactResource($contact);
    }

    /**
     * Delete a resource from the storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Shipper $shipper, Contact $contact)
    {
        if ($contact->delete()) {
            $status = Response::HTTP_OK;
            $message = 'Contact has been deleted successfully!';
        } else {
            $status = Response::HTTP_BAD_REQUEST;
            $message = 'Contact could not be deleted!';
        }

        return response()->json(['message' => $message], $status);
    }
}
