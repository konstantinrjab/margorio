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
            'address_en'                => fake()->address(),
            'address_uk'                => fake('uk_UA')->address(),
            'bank_details_en'           => fake()->text(50),
            'bank_details_uk'           => fake('uk_UA')->text(50),
            'invoice_subject_en'        => fake()->word(),
            'invoice_subject_uk'        => fake('uk_UA')->word(),
            'invoice_description_en'    => fake()->text(50),
            'invoice_description_uk'    => fake('uk_UA')->text(50),
            'last_invoice_number'       => fake()->numberBetween(1, 5),
            'last_invoice_generated_at' => fake()->dateTimeBetween('-5 month'),
        ];
    }
}
