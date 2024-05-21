<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Payment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create 50 parents
        $parents = User::factory()->count(50)->create(['role' => 'P']);

        // Create 3 administrators
        $admins = User::factory()->count(3)->create(['role' => 'A']);

        foreach ($parents as $parent) {
            // Randomly determine the number of children for each parent (1 to 3)
            $numberOfChildren = rand(1, 3);

            // Create children for each parent
            $children = Student::factory()->count($numberOfChildren)->create(['user_id' => $parent->id]);

            // Create 6 payments for each student with a 1-month difference
            foreach ($children as $child) {
                $paymentDate = now()->subMonths(6)->startOfMonth(); // Start 6 months ago
                for ($i = 0; $i < 6; $i++) {
                    $paymentDate->addMonth(); // Add 1 month
                    Payment::factory()->create([
                        'student_id' => $child->id,
                        'date' => $paymentDate,
                    ]);
                }
            }
        }
    }
}

