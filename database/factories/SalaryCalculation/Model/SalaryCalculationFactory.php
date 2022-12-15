<?php

namespace Database\Factories\SalaryCalculation\Model;

use App\SalaryCalculation\Model\SalaryCalculation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\SalaryCalculation\Model\SalaryCalculation>
 */
class SalaryCalculationFactory extends Factory
{
    protected $model = SalaryCalculation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fullMonth = fake()->boolean;

        return [
            'employee_id'  => 1,
            'working_days' => $fullMonth ? fake()->numberBetween(10, 20) : null,
            'days_worked'  => $fullMonth ? fake()->numberBetween(10, 20) : null,
            'date'         => fake()->dateTimeBetween('-1 year'),
        ];
    }
}
