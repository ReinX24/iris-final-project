<?php

namespace App\Listeners;

use App\Events\CheckJobForExpiry;
use App\Events\JobExpiryCheckRequested;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UpdateJobStatusOnExpiry
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CheckJobForExpiry $event): void
    {
        $job = $event->job;

        Log::info("Checking status for Job ID: {$job->id} (Title: {$job->title})");

        // Only proceed if the job is not already expired
        if ($job->status !== 'expired') {
            $originalStatus = $job->status;
            // $dateNeeded = Carbon::parse($job->date_needed);
            $dateExpiry = $job->date_expiry ? Carbon::parse($job->date_expiry) : null;

            $newStatus = $originalStatus; // Start with current status

            if ($dateExpiry) {
                if (Carbon::now()->greaterThan($dateExpiry)) {
                    $newStatus = 'expired';
                }
            }

            // Update the job status if it has changed
            if ($job->status !== $newStatus) {
                $job->status = $newStatus;
                $job->save();
                Log::info("Job ID: {$job->id} status updated from '{$originalStatus}' to '{$newStatus}'.");
            } else {
                Log::info("Job ID: {$job->id} status remains '{$originalStatus}'. No change needed.");
            }
        } else {
            Log::info("Job ID: {$job->id} is already 'expired'. No action needed.");
        }
    }
}
