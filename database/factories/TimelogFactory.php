<?php

namespace Database\Factories;

use App\Models\Contract;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Timelog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timelog>
 */
class TimelogFactory extends Factory {
    protected $model = Timelog::class;

    public function definition(): array {
        $randomCustomer = Customer::inRandomOrder()->first();
        $randomService = Service::inRandomOrder()->first();
        $randomContract = Contract::inRandomOrder()->first();

        return [
            'customer_id' => $randomCustomer->id,
            'service_id'  => $randomService->id,
            'contract_id' => $randomContract->id,
            'hours'       => $this->faker->numberBetween(1, 8),
            'date'        => $this->faker->date(),
            'description' => $this->faker->text(),
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }
}
