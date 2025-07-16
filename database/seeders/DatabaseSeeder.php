<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\JobOpening;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Admin account
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => 'admin',
        ]);

        // User account
        User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => 'password',
            'role' => 'user',
        ]);

        $this->call([
            JobOpeningSeeder::class,
            ApplicantSeeder::class,
            ApplicationFeeSeeder::class
        ]);
    }
}
