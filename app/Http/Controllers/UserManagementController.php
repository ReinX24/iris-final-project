<?php

namespace App\Http\Controllers;

use App\Events\AdminUserCreated;
use App\Models\AdminActionLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view("user_management.index", [
            "users" => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("user_management.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming request data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // 'unique:users' ensures email is not already taken
            'password' => ['required', 'string', 'min:8', 'confirmed'], // 'confirmed' checks if 'password' matches 'password_confirmation'
            'role' => ['required', 'string', Rule::in(['user', 'admin'])], // 'Rule::in' ensures role is 'user' or 'admin'
        ]);

        // 2. Create a new User record in the database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password for security
            'role' => $request->role, // Assign the selected role
        ]);

        $admin = Auth::user(); // Get the currently authenticated user (who is the admin creating the user)

        // Store the admin action in the database
        AdminActionLog::create([
            'admin_id' => $admin ? $admin->id : null, // Store the ID of the admin who performed the action
            'action_type' => 'user_created', // Define the type of action
            'target_id' => $user->id, // Store the ID of the affected user
            'target_type' => get_class($user), // Store the full class name of the affected model (e.g., 'App\Models\User')
            'details' => [ // Store additional relevant details about the action as JSON
                'email' => $user->email,
                'role' => $user->role,
                'name' => $user->name,
            ],
        ]);

        // 3. Redirect to the user index page with a success message
        return redirect()->route('user_management.show', $user->id)->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view("user_management.show", ["user" => User::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('user_management.edit', ['user' => User::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Find the user based on the provided ID
        $user = User::findOrFail($id); // Will throw a 404 if user not found

        // 2. Validate the incoming request data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Email must be unique, but ignore the current user's email ID
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            // Password is optional for update. If provided, it must meet criteria.
            'password' => ['nullable', 'string', 'min:8', 'confirmed'], // 'confirmed' checks against password_confirmation
            'role' => ['required', 'string', Rule::in(['user', 'admin'])], // Role must be 'user' or 'admin'
        ]);

        // 3. Update the user's attributes
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        // 4. Only update password if a new one was provided (i.e., the field is not empty)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password); // Hash the new password
        }

        // 5. Save the changes to the database
        $user->save();

        $admin = Auth::user(); // Get the currently authenticated user (who is the admin creating the user)

        // Store the admin action in the database
        AdminActionLog::create([
            'admin_id' => $admin ? $admin->id : null, // Store the ID of the admin who performed the action
            'action_type' => 'user_updated', // Define the type of action
            'target_id' => $user->id, // Store the ID of the affected user
            'target_type' => get_class($user), // Store the full class name of the affected model (e.g., 'App\Models\User')
            'details' => [ // Store additional relevant details about the action as JSON
                'email' => $user->email,
                'role' => $user->role,
                'name' => $user->name,
            ],
        ]);

        // 6. Redirect back to the user index page with a success message
        return redirect()->route('user_management.show', $user->id)->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $admin = Auth::user();

        // Store the admin action in the database
        AdminActionLog::create([
            'admin_id' => $admin ? $admin->id : null, // Store the ID of the admin who performed the action
            'action_type' => 'user_deleted', // Define the type of action
            'target_id' => $user->id, // Store the ID of the affected user
            'target_type' => get_class($user), // Store the full class name of the affected model (e.g., 'App\Models\User')
            'details' => [ // Store additional relevant details about the action as JSON
                'email' => $user->email,
                'role' => $user->role,
                'name' => $user->name,
            ],
        ]);

        $user->delete();

        return redirect()->route('user_management.index')->with('success', 'User deleted successfully!');
    }
}
