<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory {
    protected $model = Customer::class;

    public function definition(): array {
        return [
            'name'              => $this->faker->company(),
            'managing_director' => $this->faker->name,
            'phone'             => $this->faker->optional()->phoneNumber,
            'email'             => $this->faker->unique()->safeEmail,
            'street'            => $this->faker->optional()->streetName,
            'house_number'      => $this->faker->optional()->buildingNumber,
            'zip_code'          => $this->faker->optional()->postcode,
            'city'              => $this->faker->optional()->city,
            'created_at'        => now(),
            'updated_at'        => now(),
        ];
    }
}
