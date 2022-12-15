<?php

namespace Database\Factories\Reimbursement\Model;

use App\Reimbursement\Model\Reimbursement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Reimbursement\Model\Reimbursement>
 */
class ReimbursementFactory extends Factory
{
    protected $model = Reimbursement::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'employee_id' => 1,
            'description' => fake()->text(30),
            'approved'    => fake()->boolean(),
            'amount'      => fake()->numberBetween(10, 500),
            'date'        => fake()->dateTimeBetween('-1 year'),
        ];
    }
}
