<?php

namespace Database\Factories\Employee\Model;

use App\Employee\Model\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Employee\Model\Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'full_name_uk'              => fake('uk_UA')->name(),
            'full_name_en'              => fake()->name(),
            'tax_number'                => fake()->randomNumber(8),
            'invoice_data'                   => [
                'full' => [
                    'address_en'      => $address = fake()->address(),
                    'address_uk'      => fake('uk_UA')->address(),
                    'bank_details_en' => $bankDetails = fake()->text(50),
                    'bank_details_uk' => fake('uk_UA')->text(50),
                    'subject_en'      => $subject = fake()->word(),
                    'subject_uk'      => fake('uk_UA')->word(),
                    'description_en'  => $description = fake()->text(50),
                    'description_uk'  => fake('uk_UA')->text(50),
                ],
                'probation' => [
                    'address_en'      => $address . ' probation',
                    'bank_details_en' => $bankDetails . ' probation',
                    'subject_en'      => $subject . ' probation',
                    'description_en'  => $description . ' probation',
                ],
            ],
            'last_invoice_number'       => fake()->numberBetween(1, 5),
            'last_invoice_generated_at' => fake()->dateTimeBetween('-5 month'),
        ];
    }
}
