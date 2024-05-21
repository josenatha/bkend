<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
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
            'id' => Str::uuid(),
            'name' => $this->faker->firstName,
            'first_surname' => $this->faker->lastName,
            'second_surname' => $this->faker->lastName,
            'date_of_birth' => $this->faker->date('Y-m-d', '2006-01-01'),
            'gender' => $this->faker->randomElement(['M', 'F', 'U']),
            'neighborhood' => $this->faker->streetName,
            'street' => $this->faker->streetAddress,
            'phone_number' => '664' . $this->faker->numerify('#######'),
            'photo' => $this->faker->imageUrl(200, 200, 'people'),
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'email_verified_at' => null,
            'role' => $this->faker->randomElement(['A', 'P']),
            'status' => $this->faker->randomDigit % 10 === 0 ? false : true,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
