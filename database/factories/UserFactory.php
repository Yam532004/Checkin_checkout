<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
        public function definition()
        {
            return [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make('password'), // password
                'phone_number' => $this->faker->phoneNumber,
                'role' => $this->faker->randomElement('user'),
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ];
        }
}
