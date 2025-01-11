<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->name(),
            'gmail'=>fake()->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'phone'=>fake()->numberBetween($min = 123456789, $max = 98561237894),
            'gender' =>fake()->randomElement(['male', 'female']),
            'role' => Role::CUSTOMER,
            'birthday' => fake()->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null),

          /*
           todo  'profile_photo'=>$path,
           todo  'Personal_card'=>fake()->numberBetween($min = 10000000000000, $max = 900000000000),
           todo  'email_verified_at' => now(),
           todo 'gmail'=>fake()->unique()->safeEmail(),
           todo  'phone'=>fake()->numberBetween($min = 123456789, $max = 98561237894),
           todo 'profile_photo'=>fake()->imageUrl($width=400, $height=400),
          */
        ];
    }



    // ? seed Admin account
    public function admin()
        {
        return $this->state(function (array $attributes) {
            return [
                
                'role' => Role::ADMIN,
            ];
        });
    }

    
    // ? seed customer account
    public function CUSTOMER()
        {
        return $this->state(function (array $attributes) {
            return [
                'role' => Role::CUSTOMER,
            ];
        });
    }


            /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
