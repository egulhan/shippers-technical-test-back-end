<?php

namespace Database\Factories;

use App\Models\Shipper;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'shipper_id' => Shipper::factory()->create()->id,
            'is_primary' => false,
            'name' => $this->faker->name,
            'contact_number' => $this->faker->phoneNumber,
        ];
    }

    /**
     * Indicate that the contact is primary.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function primary()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_primary' => true,
            ];
        });
    }
}
