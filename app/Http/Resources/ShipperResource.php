<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShipperResource extends JsonResource
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
            'company_name' => $this->company_name,
            'address' => $this->address,
            'primary_contact' => new ContactResource($this->whenLoaded('primaryContact')),
            'contacts' => ContactResource::collection($this->whenLoaded('contacts')),
            'created_at' => isset($this->created_at) ? $this->created_at->format('Y-m-d H:i:s') : null,
            'updated_at' => isset($this->updated_at) ? $this->updated_at->format('Y-m-d H:i:s') : null,
        ];
    }
}
