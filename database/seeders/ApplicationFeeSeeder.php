<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\ApplicationFee;
use App\Models\JobOpening;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure there are enough applicants and job openings before creating fees
        if (Applicant::count() === 0) {
            $this->call(ApplicantSeeder::class);
            $this->command->info('Called ApplicantSeeder as no applicants found.');
        }
        if (JobOpening::count() === 0) {
            $this->call(JobOpeningSeeder::class);
            $this->command->info('Called JobOpeningsSeeder as no job openings found.');
        }

        // Create 50 application fee records
        ApplicationFee::factory()->count(50)->create();

        $this->command->info('Created 50 application fee records.');
    }
}
