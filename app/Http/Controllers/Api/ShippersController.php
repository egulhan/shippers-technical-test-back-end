<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShipperRequest;
use App\Http\Resources\ShipperResource;
use App\Models\Shipper;
use Illuminate\Http\Response;

class ShippersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param StoreShipperRequest $request
     * @return ShipperResource|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $shippers = Shipper::with('primaryContact')->latest()->get();
        return ShipperResource::collection($shippers);
    }

    /**
     * Display contact listing of the shipper.
     *
     * @param StoreShipperRequest $request
     * @return ShipperResource|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function listContacts(Shipper $shipper)
    {
        $shipper->load(['contacts' => function ($query) {
            // order by is_primary col. to show the primary contact at the top of the list
            $query->orderBy('is_primary', 'desc');
        }]);

        return new ShipperResource($shipper);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreShipperRequest $request
     * @return ShipperResource
     */
    public function store(StoreShipperRequest $request)
    {
        $shipper = new Shipper([
            'company_name' => $request->company_name,
            'address' => $request->address,
        ]);

        $shipper->save();

        return new ShipperResource($shipper);
    }

    /**
     * Update a resource in storage.
     *
     * @param StoreShipperRequest $request
     * @param Shipper $shipper
     * @return ShipperResource
     */
    public function update(StoreShipperRequest $request, Shipper $shipper)
    {
        $shipper->company_name = $request->company_name;
        $shipper->address = $request->address;
        $shipper->save();

        return new ShipperResource($shipper);
    }
}
