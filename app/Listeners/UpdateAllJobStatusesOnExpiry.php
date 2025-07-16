<?php

namespace App\Listeners;

use App\Models\JobOpening;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UpdateAllJobStatusesOnExpiry implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(public JobOpening $job) {}

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        Log::info('Starting full job status check via event...');

        $updatedCount = 0;

        // Fetch all job openings that are not already 'expired'
        // We fetch all to re-evaluate their status based on current date and their own dates.
        $jobs = JobOpening::where('status', '!=', 'expired')->get();

        foreach ($jobs as $job) {
            $originalStatus = $job->status;
            // $dateNeeded = Carbon::parse($job->date_needed);
            $dateExpiry = $job->date_expiry ? Carbon::parse($job->date_expiry) : null;

            $newStatus = $originalStatus; // Start with the current status

            if ($dateExpiry) {
                // Condition for 'expired' status: date_expiry is in the past OR date_needed is after date_expiry
                // if ($dateExpiry->isPast() || $dateNeeded->greaterThan($dateExpiry)) {
                if (Carbon::now()->greaterThan($dateExpiry)) {
                    $newStatus = 'expired';
                }
            }

            // Update the job status if it has changed
            if ($job->status !== $newStatus) {
                $job->status = $newStatus;
                $job->save();
                $updatedCount++;
                Log::info("Job ID: {$job->id} status updated from '{$originalStatus}' to '{$newStatus}'.");
            }
        }

        Log::info("Full job status check completed. Updated {$updatedCount} job statuses.");
    }
}
