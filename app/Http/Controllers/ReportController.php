<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\JobOpening;
use App\Models\LoginEvent;
use App\Models\AdminActionLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Str; // For string manipulation (e.g., class names)

class ReportController extends Controller
{
    public function jobReports(Request $request)
    {
        $query = JobOpening::query();

        // Apply existing filters
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }
        if ($request->filled('date_needed')) {
            $query->whereDate('date_needed', '>=', $request->input('date_needed'));
        }
        if ($request->filled('date_expiry')) {
            $query->whereDate('date_expiry', '<=', $request->input('date_expiry'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Apply new Applicants filter
        if ($request->filled('applicant_id')) {
            $applicantId = $request->input('applicant_id');
            // If JobOpening has many applicants (e.g., through a pivot table 'job_opening_applicant'):
            $query->whereHas('applicants', function ($q) use ($applicantId) {
                $q->where('applicants.id', $applicantId);
            });
        }

        // Ensure applicants_count is loaded for the view
        $jobOpenings = $query->paginate(10); // Or your preferred pagination

        // Fetch all applicants for the dropdown
        $applicants = Applicant::orderBy('name')->get(); // Assuming 'name' is the applicant's name field

        return view('reports.jobs', compact('jobOpenings', 'applicants'));
    }

    public function applicantReports(Request $request)
    {
        $query = Applicant::query();

        // Apply filters based on request
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->filled('min_age')) {
            $query->where('age', '>=', $request->input('min_age'));
        }
        if ($request->filled('max_age')) {
            $query->where('age', '<=', $request->input('max_age'));
        }
        if ($request->filled('educational_attainment')) {
            $query->where('educational_attainment', $request->input('educational_attainment'));
        }
        if ($request->filled('medical')) {
            $query->where('medical', $request->input('medical'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Paginate the results
        $applicants = $query->paginate(10); // Adjust pagination limit as needed

        // Pass the paginated data and request query to the view
        return view('reports.applicants', compact('applicants'));
    }

    public function downloadApplicantsCsv(Request $request)
    {
        $query = Applicant::query();

        // Re-apply filters for the CSV download
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->filled('min_age')) {
            $query->where('age', '>=', $request->input('min_age'));
        }
        if ($request->filled('max_age')) {
            $query->where('age', '<=', $request->input('max_age'));
        }
        if ($request->filled('educational_attainment')) {
            $query->where('educational_attainment', $request->input('educational_attainment'));
        }
        if ($request->filled('medical')) {
            $query->where('medical', $request->input('medical'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $applicants = $query->get(); // Get all filtered applicants for download

        $filename = 'applicants_report_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($applicants) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'ID',
                'Name',
                'Age',
                'Educational Attainment',
                'Medical',
                'Status',
                'Working Experience' // Include this if you want it in CSV
            ]);

            // Add data rows
            foreach ($applicants as $applicant) {
                fputcsv($file, [
                    $applicant->id,
                    $applicant->name,
                    $applicant->age,
                    $applicant->educational_attainment,
                    $applicant->medical,
                    $applicant->status,
                    $applicant->working_experience
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function downloadJobsCsv(Request $request)
    {
        $query = JobOpening::query();

        // Apply existing filters
        if ($request->filled('date_needed')) {
            $query->whereDate('date_needed', '>=', $request->input('date_needed'));
        }
        if ($request->filled('date_expiry')) {
            $query->whereDate('date_expiry', '<=', $request->input('date_expiry'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Apply new Applicants filter to CSV download
        if ($request->filled('applicant_id')) {
            $applicantId = $request->input('applicant_id');
            $query->whereHas('applicants', function ($q) use ($applicantId) {
                $q->where('applicants.id', $applicantId);
            });
        }

        $jobOpenings = $query->withCount('applicants')->get();

        $filename = 'job_openings_report_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($jobOpenings) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID',
                'Title',
                'Location',
                'Status',
                'Date Needed',
                'Date Expiry',
                'Applicants'
            ]);

            foreach ($jobOpenings as $job) {
                fputcsv($file, [
                    $job->id,
                    $job->title,
                    $job->location,
                    ucfirst($job->status),
                    $job->date_needed->format('M d, Y'),
                    $job->date_expiry ? $job->date_expiry->format('M d, Y') : 'N/A',
                    $job->applicants_count
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    /**
     * Display the login events report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function loginReports(Request $request)
    {
        $query = LoginEvent::query()
            ->with('user'); // Eager load the user relationship

        // Apply filters based on request
        if ($request->filled('user_name_email')) {
            $searchTerm = '%' . $request->input('user_name_email') . '%';
            $query->whereHas('user', function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('email', 'like', $searchTerm);
            });
        }

        if ($request->filled('ip_address')) {
            $query->where('ip_address', 'like', '%' . $request->input('ip_address') . '%');
        }

        if ($request->filled('start_date')) {
            $query->whereDate('logged_in_at', '>=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->whereDate('logged_in_at', '<=', $request->input('end_date'));
        }

        // Order by latest login first
        $query->orderBy('logged_in_at', 'desc');

        // Paginate the results
        $loginEvents = $query->paginate(10); // Adjust pagination limit as needed

        // Pass the paginated data to the view
        return view('reports.login-events', compact('loginEvents'));
    }

    /**
     * Handle the download of the login events report as CSV.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadLoginReportsCsv(Request $request)
    {
        $query = LoginEvent::query()
            ->with('user');

        // Apply the same filters as the report page
        if ($request->filled('user_name_email')) {
            $searchTerm = '%' . $request->input('user_name_email') . '%';
            $query->whereHas('user', function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('email', 'like', $searchTerm);
            });
        }

        if ($request->filled('ip_address')) {
            $query->where('ip_address', 'like', '%' . $request->input('ip_address') . '%');
        }

        if ($request->filled('start_date')) {
            $query->whereDate('logged_in_at', '>=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->whereDate('logged_in_at', '<=', $request->input('end_date'));
        }

        $query->orderBy('logged_in_at', 'desc');

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="login_events_report.csv"',
        ];

        // Use a streamed response for large datasets to avoid memory issues
        return response()->stream(function () use ($query) {
            $file = fopen('php://output', 'w');

            // Add CSV header row
            fputcsv($file, ['ID', 'User Name', 'User Email', 'IP Address', 'User Agent', 'Logged In At']);

            // Chunk results to process large datasets efficiently
            $query->chunk(1000, function ($events) use ($file) {
                foreach ($events as $event) {
                    fputcsv($file, [
                        $event->id,
                        $event->user->name ?? 'N/A', // Handle case where user might be null
                        $event->user->email ?? 'N/A',
                        $event->ip_address,
                        $event->user_agent,
                        $event->logged_in_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($file);
        }, 200, $headers);
    }

    /**
     * Display the admin action logs report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function adminActionReports(Request $request)
    {
        $query = AdminActionLog::query()
            ->with(['admin', 'target']); // Eager load the admin and polymorphic target relationships

        // Apply filters based on request
        if ($request->filled('admin_name_email')) {
            $searchTerm = '%' . $request->input('admin_name_email') . '%';
            $query->whereHas('admin', function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('email', 'like', $searchTerm);
            });
        }

        if ($request->filled('action_type')) {
            $query->where('action_type', $request->input('action_type'));
        }

        if ($request->filled('target_type')) {
            // Convert short name to full class name if necessary, or ensure input is full class name
            $targetType = $request->input('target_type');
            if ($targetType === 'User') { // Example: if form sends 'User', convert to 'App\Models\User'
                $query->where('target_type', \App\Models\User::class);
            } else {
                $query->where('target_type', $targetType);
            }
        }

        if ($request->filled('target_id')) {
            $query->where('target_id', $request->input('target_id'));
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->input('end_date'));
        }

        // Order by latest action first
        $query->orderBy('created_at', 'desc');

        // Paginate the results
        $adminActions = $query->paginate(10); // Adjust pagination limit as needed

        // Get distinct action types for the filter dropdown
        $actionTypes = AdminActionLog::select('action_type')->distinct()->pluck('action_type')->toArray();

        // Get distinct target types for the filter dropdown
        $targetTypes = AdminActionLog::select('target_type')->distinct()->pluck('target_type')->map(function ($type) {
            return Str::afterLast($type, '\\'); // Get just the class name without namespace
        })->unique()->toArray();

        // Pass the paginated data and filter options to the view
        return view('reports.admin-actions', compact('adminActions', 'actionTypes', 'targetTypes'));
    }

    /**
     * Handle the download of the admin action logs report as CSV.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadAdminActionReportsCsv(Request $request)
    {
        $query = AdminActionLog::query()
            ->with(['admin', 'target']); // Eager load relationships for CSV

        // Apply the same filters as the report page
        if ($request->filled('admin_name_email')) {
            $searchTerm = '%' . $request->input('admin_name_email') . '%';
            $query->whereHas('admin', function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('email', 'like', $searchTerm);
            });
        }

        if ($request->filled('action_type')) {
            $query->where('action_type', $request->input('action_type'));
        }

        if ($request->filled('target_type')) {
            $targetType = $request->input('target_type');
            if ($targetType === 'User') {
                $query->where('target_type', \App\Models\User::class);
            } else {
                $query->where('target_type', $targetType);
            }
        }

        if ($request->filled('target_id')) {
            $query->where('target_id', $request->input('target_id'));
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->input('end_date'));
        }

        $query->orderBy('created_at', 'desc');

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="admin_actions_report.csv"',
        ];

        return response()->stream(function () use ($query) {
            $file = fopen('php://output', 'w');

            // Add CSV header row
            fputcsv($file, [
                'Log ID',
                'Admin Name',
                'Admin Email',
                'Action Type',
                'Target Type',
                'Target ID',
                'Target Name/Email (if User)', // Adjusted for clarity
                'Details',
                'Action At'
            ]);

            // Chunk results for large datasets
            $query->chunk(1000, function ($actions) use ($file) {
                foreach ($actions as $action) {
                    $targetNameOrEmail = 'N/A';
                    if ($action->target_type === \App\Models\User::class && $action->target) {
                        $targetNameOrEmail = $action->target->name . ' (' . $action->target->email . ')';
                    } else if ($action->target) {
                        // For other target types, you might want to display a relevant attribute
                        // e.g., $action->target->title for a JobOpening, or just its ID.
                        $targetNameOrEmail = $action->target->id; // Fallback to ID
                    }

                    fputcsv($file, [
                        $action->id,
                        $action->admin->name ?? 'Deleted Admin',
                        $action->admin->email ?? 'N/A',
                        $action->action_type,
                        Str::afterLast($action->target_type, '\\') ?? 'N/A', // Just class name
                        $action->target_id,
                        $targetNameOrEmail,
                        json_encode($action->details), // Encode JSON details for CSV
                        $action->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($file);
        }, 200, $headers);
    }
}
