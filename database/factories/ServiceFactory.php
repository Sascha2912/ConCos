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
        return [
            'name'          => $this->faker->word,
            'description'   => $this->faker->optional()->paragraph,
            'cost_per_hour' => $this->faker->randomFloat(2, 20, 200),
            'created_at'    => now(),
            'updated_at'    => now(),
        ];
    }
}
