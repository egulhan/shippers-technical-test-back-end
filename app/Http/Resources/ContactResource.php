<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'shipper' => new ShipperResource($this->whenLoaded('shipper')),
            'is_primary' => $this->is_primary,
            'name' => $this->name,
            'contact_number' => $this->contact_number,
            'created_at' => isset($this->created_at) ? $this->created_at->format('Y-m-d H:i:s') : null,
            'updated_at' => isset($this->updated_at) ? $this->updated_at->format('Y-m-d H:i:s') : null,
        ];
    }
}
