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
        return [
            'name'          => $this->faker->jobTitle().' Contract',
            'monthly_costs' => $this->faker->optional()->randomFloat(2, 100, 1000) ?? 0,
            'flatrate'      => $this->faker->boolean,
            'created_at'    => now(),
            'updated_at'    => now(),
        ];
    }
}
