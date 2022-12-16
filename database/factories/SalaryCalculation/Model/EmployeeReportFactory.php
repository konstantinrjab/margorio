<?php

namespace Database\Factories\SalaryCalculation\Model;

use App\SalaryCalculation\Model\EmployeeReport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\SalaryCalculation\Model\EmployeeReport>
 */
class EmployeeReportFactory extends Factory
{
    protected $model = EmployeeReport::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'employee_id'  => 1,
            'working_days' => fake()->numberBetween(10, 20),
            'days_worked'  => fake()->numberBetween(10, 20),
            'date'         => fake()->dateTimeBetween('-1 year'),
        ];
    }
}
