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
            'name'          => $this->faker->word,
            'hours'         => $this->faker->optional()->numberBetween(10, 200),
            'monthly_costs' => $this->faker->optional()->randomFloat(2, 100, 1000),
            'flatrate'      => $this->faker->boolean,
            'start_date'    => Carbon::now()->subMonths($this->faker->numberBetween(1, 12)),
            'end_date'      => $this->faker->optional()->dateTimeBetween('now', '+2 years'),
            'created_at'    => now(),
            'updated_at'    => now(),
        ];
    }
}
