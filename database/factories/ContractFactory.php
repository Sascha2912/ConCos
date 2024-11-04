<?php

namespace Database\Factories;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory {
    protected $model = Contract::class;

    public function definition(): array {
        $index = $this->faker->unique()->numberBetween(1, 1000);

        return [
            'name'          => ' Contract '.$index,
            'monthly_costs' => $this->faker->randomFloat(2, 50, 1000),
            'flatrate'      => $this->faker->boolean(20),
            'created_at'    => now(),
            'updated_at'    => now(),
        ];
    }
}
