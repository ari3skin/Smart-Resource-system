<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();
        $org_domain = 'arcadianbank.com';
        $com_domains = fake()->randomElement(['gmail.com', 'outlook.com', 'yahoo.com', 'icloud.com']);

        return [
            //
            'department_id' => fake()->randomElement([101, 102, 103, 104, 105]),
            'designation_id' => fake()->randomElement([101, 102, 103, 104, 105, 106]),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => strtolower($firstName . '.' . $lastName . '@' . $org_domain),
            'phone_number' => fake()->phoneNumber(),
            'employed_date' => fake()->dateTime(),
            'DOB' => fake()->dateTime(),
            'current_salary_amount' => fake()->randomElement(['Ksh 160000', 'Ksh 2350000', 'Ksh 757890', 'Ksh 1750630'])
        ];
    }
}
