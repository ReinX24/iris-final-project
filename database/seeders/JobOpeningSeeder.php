<?php

namespace Database\Seeders;

use App\Models\JobOpening;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobOpeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 20 active job openings
        JobOpening::factory()->count(20)->active()->create();
        $this->command->info('Created 20 active job openings.');

        // Create 20 inactive job openings
        JobOpening::factory()->count(20)->inactive()->create();
        $this->command->info('Created 20 inactive job openings.');

        // Create 20 job openings that will expire today
        JobOpening::factory()->count(20)->expiresToday()->create();
        $this->command->info('Created 20 inactive job openings.');

        // Create 10 expired job openings
        JobOpening::factory()->count(10)->expired()->create();
        $this->command->info('Created 10 expired job openings.');
    }
}
