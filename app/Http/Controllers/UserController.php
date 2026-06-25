<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        // Ensure only admin users can access these methods
        $this->middleware('auth:admin');
    }
    
    public function index()
    {
        // Views
        $users = DB::table('users_view')->get();
        foreach ($users as $user) {
            $user->created_at = \Carbon\Carbon::parse($user->created_at);
            $user->updated_at = \Carbon\Carbon::parse($user->updated_at);
            $user->email_verified_at = $user->email_verified_at ? \Carbon\Carbon::parse($user->email_verified_at) : null;
        }
        
        return view('admin.dashboard', compact('users'));
    }
    
    public function showUsers()
    {
        // Use simplePaginate instead of paginate for simpler Previous/Next only
        $users = DB::table('users_view')->simplePaginate(10);
        
        // Format the date fields
        foreach ($users as $user) {
            $user->created_at = \Carbon\Carbon::parse($user->created_at);
        }
        
        return view('admin/users', compact('users'));
    }
    
    public function deleteUser($id)
    {
        // Call the stored procedure to delete the user
        DB::statement('CALL DeleteUser (?)', [$id]);
    
        // Redirect back to the users list with a success message
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }
    
    public function showUser()
    {
        // Directly query the user_logs table with a join to users table
        // Only select the necessary columns
        $userLogs = DB::table('user_logs as ul')
                      ->leftJoin('users as u', 'ul.user_id', '=', 'u.id')
                      ->select([
                          'ul.id',
                          'ul.user_id',
                          'ul.operation',
                          'ul.changed_data',
                          'ul.performed_at',
                          DB::raw('COALESCE(u.name, "Deleted User") as user_name'),
                          DB::raw('COALESCE(u.email, "deleted@example.com") as user_email')
                      ])
                      ->orderBy('ul.performed_at', 'desc')
                      ->simplePaginate(15);
    
        // Format the date fields
        foreach ($userLogs as $log) {
            $log->performed_at = \Carbon\Carbon::parse($log->performed_at);
        }
    
        // Pass the logs to the view
        return view('admin/user_logs', compact('userLogs'));
    }
    
    /**
     * Show the form for editing a user
     */
    public function editUser($id)
    {
        // Get the user by ID
        $user = DB::table('users_view')->where('id', $id)->first();
        
        if (!$user) {
            return redirect()->route('admin.users')->with('error', 'User not found.');
        }
        
        return view('admin.userupdate', compact('user'));
    }
    
    /**
     * Update the user in the database
     */
    public function updateUser(Request $request, $id)
    {
        // Get current user data
        $currentUser = DB::table('users')->where('id', $id)->first();

        // Check if any changes were made
        $hasChanges = false;
        
        // Validate the request data
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ];

        // Check if either password field is filled
        if ($request->filled('password') || $request->filled('password_confirmation')) {
            $rules['password'] = 'required|string|min:8|confirmed';
            $rules['password_confirmation'] = 'required';
        }

        try {
            $validated = $request->validate($rules);
            
            // Update user information only if changed
            $data = [];
            
            if ($request->name !== $currentUser->name) {
                $data['name'] = $request->name;
                $hasChanges = true;
            }
            
            if ($request->email !== $currentUser->email) {
                $data['email'] = $request->email;
                $hasChanges = true;
            }
            
            // Only update password if both fields are properly filled and validated
            if ($request->filled('password') && $request->filled('password_confirmation')) {
                $data['password'] = Hash::make($request->password);
                $hasChanges = true;
            }
            
            // Only update if there are changes
            if ($hasChanges) {
                DB::table('users')->where('id', $id)->update($data);
                return redirect()->route('admin.users')->with('success', 'User updated successfully.');
            } else {
                return redirect()->back()->with('error', 'No changes were made.');
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                           ->withErrors($e->validator)
                           ->withInput()
                           ->with('error', 'Both password fields must be filled correctly.');
        }
    }
    
    /**
     * Store a new user
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('admin.users')
                           ->with('success', 'User added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to add user: ' . $e->getMessage());
        }
    }
    
    /**
     * Check if email already exists
     */
    public function checkEmail(Request $request)
    {
        $exists = User::where('email', $request->email)->exists();
        
        return response()->json(['exists' => $exists]);
    }
}