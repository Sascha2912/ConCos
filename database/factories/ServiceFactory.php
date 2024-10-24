<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory {
    protected $model = Service::class;

    public function definition(): array {
        $index = $this->faker->unique()->numberBetween(1, 1000);

        return [
            'name'           => 'Service '.$index,
            'description'    => $this->faker->optional()->paragraph,
            'costs_per_hour' => $this->faker->randomFloat(2, 20, 200),
            'created_at'     => now(),
            'updated_at'     => now(),
        ];
    }
}
