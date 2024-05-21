<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'name' => $this->faker->firstName,
            'first_surname' => $this->faker->lastName,
            'second_surname' => $this->faker->lastName,
            'date_of_birth' => $this->faker->dateTimeBetween('2009-01-01', '2020-01-01')->format('Y-m-d'),
            'gender' => $this->faker->randomElement(['M', 'F', 'U']),
            'curp' => $this->faker->regexify('[A-Z]{4}\d{6}[HM][A-Z]{5}[A-Z\d][\dA]'),
            'blood_type' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']), 
            'photo' => $this->faker->imageUrl(200, 200, 'people'),
            'birth_certificate' => null,
            'grade' => $this->faker->randomElement(['Pre-Kinder', '1st Grade', '2nd Grade', '3rd Grade', '4th Grade', '5th Grade', '6th Grade']),
            'note' => null,
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'status' => $this->faker->randomElement(['Active', 'Inactive', 'Under review']),
        ];
    }
}
