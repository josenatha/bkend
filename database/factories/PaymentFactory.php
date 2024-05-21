<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'amount' => 4000.00,
            'date' => $this->faker->dateTimeBetween('2024-05-15', '2024-12-15')->format('Y-m-d'),
            'photo' => $this->faker->imageUrl(640, 480, 'invoice'),
            'note' => null,
            'student_id' => function () {
                return \App\Models\Student::factory()->create()->id;
            },
            'verified' => true,
        ];
    }
}
