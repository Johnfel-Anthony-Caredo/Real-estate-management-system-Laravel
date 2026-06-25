<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Admin;
use App\Models\User;
use App\Models\Prop\Property;
use App\Models\Prop\HomeType;
use App\Models\Prop\PropImage; // Add this import
use Illuminate\Support\Facades\Hash;

class AdminsController extends Controller
{
    /**
     * Show the admin login form
     */
    public function showLoginForm()
    {
        return view('admin.adminlogin');
    }

    /**
     * Handle admin login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            // Store admin name in session for use in views
            $admin = Auth::guard('admin')->user();
            session(['admin_name' => $admin->name]);
            
            return redirect()->intended('admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle admin logout request
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }

    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        // Get counts using Eloquent models
        $adminCount = Admin::count();
        $userCount = User::count();
        $propertyCount = Property::count();
        $homeTypeCount = HomeType::withoutTrashed()->count(); // Exclude soft-deleted records
        
        // Get monthly data for charts
        $currentYear = date('Y');
        
        // Monthly users data
        $monthlyUsers = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();
        
        // Monthly admins data
        $monthlyAdmins = Admin::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();
        
        // Monthly properties data
        $monthlyProperties = Property::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();
        
        // Get most requested home types data
        $mostRequestedHomeTypes = DB::table('requests')
            ->join('props', 'requests.prop_id', '=', 'props.id')
            ->selectRaw('props.home_type, COUNT(*) as request_count')
            ->groupBy('props.home_type')
            ->orderBy('request_count', 'desc')
            ->take(8) // Increased from 6 to 8 for better polar area visualization
            ->get();
        
        // Format data for charts
        $months = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];
        
        $chartData = [
            'labels' => array_values($months),
            'users' => [],
            'admins' => [],
            'properties' => []
        ];
        
        // Fill in the data for all months (even those with zero counts)
        foreach (range(1, 12) as $month) {
            $chartData['users'][] = $monthlyUsers[$month] ?? 0;
            $chartData['admins'][] = $monthlyAdmins[$month] ?? 0;
            $chartData['properties'][] = $monthlyProperties[$month] ?? 0;
        }
        
        // Format home types data for chart
        $homeTypesData = [
            'labels' => $mostRequestedHomeTypes->pluck('home_type')->toArray(),
            'counts' => $mostRequestedHomeTypes->pluck('request_count')->toArray(),
        ];
        
        // Pass the data to the dashboard view
        return view('admin.dashboard', compact(
            'adminCount', 'userCount', 'propertyCount', 'homeTypeCount', 
            'chartData', 'homeTypesData'
        ));
    }
    
    /**
     * Show all admins
     */
    public function showAdmins()
    {
        // Use the admins_view to get all admins with pagination
        $admins = DB::table('admins_view')->simplePaginate(10);
        
        // Format the date fields
        foreach ($admins as $admin) {
            $admin->created_at = \Carbon\Carbon::parse($admin->created_at);
        }
        
        return view('admin.adminview', compact('admins'));
    }
    
    /**
     * Delete an admin
     */
    public function deleteAdmin($id)
    {
        // Don't delete if it's the currently logged in admin
        $currentAdmin = Auth::guard('admin')->user();
        if ($currentAdmin->id == $id) {
            return redirect()->route('admin.admins')->with('error', 'Cannot delete your own account while logged in.');
        }
        
        // Call the stored procedure
        $status = null;
        DB::select('CALL DeleteAdmin(?, @status)', [$id]);
        $result = DB::select('SELECT @status as status');
        $status = $result[0]->status;
        
        // Check the result
        if (strpos($status, 'ERROR') !== false) {
            return redirect()->route('admin.admins')->with('error', str_replace('ERROR: ', '', $status));
        } else {
            return redirect()->route('admin.admins')->with('success', str_replace('SUCCESS: ', '', $status));
        }
    }
    
    /**
     * Show all properties
     */
    public function showProperties()
    {
        // Get all properties with pagination
        $properties = DB::table('props')->simplePaginate(10);
        
        // Format the date fields
        foreach ($properties as $property) {
            $property->created_at = \Carbon\Carbon::parse($property->created_at);
        }
        
        return view('admin.properties', compact('properties'));
    }
    
    /**
     * Delete a property
     */
    public function deleteProperty($id)
    {
        try {
            $property = DB::table('props')->where('id', $id)->first();
            
            if (!$property) {
                return redirect()->route('admin.properties')->with('error', 'Property not found.');
            }

            if ($property->image && file_exists(public_path('assets1/images/' . $property->image))) {
                unlink(public_path('assets1/images/' . $property->image));
            }

            $galleryImages = PropImage::where('prop_id', $id)->get();
            foreach ($galleryImages as $galleryImage) {
                if ($galleryImage->image && file_exists(public_path('assets1/images/' . $galleryImage->image))) {
                    unlink(public_path('assets1/images/' . $galleryImage->image));
                }
            }
            
            DB::table('props')->where('id', $id)->delete();
            
            return redirect()->route('admin.properties')->with('success', 'Property deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.properties')->with('error', 'Failed to delete property: ' . $e->getMessage());
        }
    }
    
    /**
     * Show the form for editing an admin
     */
    public function editAdmin($id)
    {
        // Get the admin by ID
        $admin = DB::table('admins_view')->where('id', $id)->first();
        
        if (!$admin) {
            return redirect()->route('admin.admins')->with('error', 'Admin not found.');
        }
        
        return view('admin.adminupdate', compact('admin'));
    }

    /**
     * Update the admin in the database
     */
    public function updateAdmin(Request $request, $id)
    {
        // Get current admin data
        $currentAdmin = DB::table('admins')->where('id', $id)->first();

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
            
            // Update admin information only if changed
            $data = [];
            
            if ($request->name !== $currentAdmin->name) {
                $data['name'] = $request->name;
                $hasChanges = true;
            }
            
            if ($request->email !== $currentAdmin->email) {
                $data['email'] = $request->email;
                $hasChanges = true;
            }
            
            // Only update password if both fields are properly filled and validated
            if ($request->filled('password') && $request->filled('password_confirmation')) {
                $data['password'] = Hash::make($request->password); // This will now work
                $hasChanges = true;
            }
            
            // Only update if there are changes
            if ($hasChanges) {
                DB::table('admins')->where('id', $id)->update($data);
                return redirect()->route('admin.admins')->with('success', 'Admin updated successfully.');
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
     * Show all home types
     */
    public function showHomeTypes()
    {
        $homeTypes = HomeType::paginate(10);
        return view('admin.hometype', compact('homeTypes'));
    }

    /**
     * Delete a home type (soft delete)
     */
    public function deleteHomeType($id)
    {
        try {
            $homeType = HomeType::findOrFail($id);
            $homeType->delete(); // This will now soft delete
            
            return redirect()->route('admin.hometypes')
                           ->with('success', 'Home type deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.hometypes')
                           ->with('error', 'Failed to delete home type: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing a home type
     */
    public function editHomeType($id)
    {
        $homeType = HomeType::findOrFail($id);
        return redirect()->route('admin.hometypes')->with('edit_home_type', $homeType->id);
    }

    /**
     * Update the home type
     */
    public function updateHomeType(Request $request, $id)
    {
        $request->validate([
            'hometypes' => 'required|string|max:255'
        ]);

        try {
            $homeType = HomeType::findOrFail($id);
            $homeType->update([
                'hometypes' => $request->hometypes
            ]);

            return redirect()->route('admin.hometypes')
                           ->with('success', 'Home type updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to update home type: ' . $e->getMessage());
        }
    }
    
    /**
     * Show trashed home types
     */
    public function showTrashedHomeTypes()
    {
        $homeTypes = HomeType::onlyTrashed()->paginate(10);
        return view('admin.hometype', compact('homeTypes'));
    }

    /**
     * Restore a soft-deleted home type
     */
    public function restoreHomeType($id)
    {
        try {
            $homeType = HomeType::onlyTrashed()->findOrFail($id);
            $homeType->restore();
            
            return redirect()->route('admin.hometypes.trashed')
                           ->with('success', 'Home type restored successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.hometypes.trashed')
                           ->with('error', 'Failed to restore home type: ' . $e->getMessage());
        }
    }

    /**
     * Permanently delete a home type
     */
    public function forceDeleteHomeType($id)
    {
        try {
            $homeType = HomeType::onlyTrashed()->findOrFail($id);
            $homeType->forceDelete();
            
            return redirect()->route('admin.hometypes.trashed')
                           ->with('success', 'Home type permanently deleted.');
        } catch (\Exception $e) {
            return redirect()->route('admin.hometypes.trashed')
                           ->with('error', 'Failed to permanently delete home type: ' . $e->getMessage());
        }
    }

    /**
     * Store a new home type
     */
    public function storeHomeType(Request $request)
    {
        $request->validate([
            'hometypes' => 'required|string|max:255|unique:hometypes,hometypes'
        ]);

        try {
            HomeType::create([
                'hometypes' => $request->hometypes
            ]);

            return redirect()->route('admin.hometypes')
                           ->with('success', 'Home type added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to add home type: ' . $e->getMessage());
        }
    }

    /**
     * Store a new admin
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('admin.admins')
                           ->with('success', 'Admin added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to add admin: ' . $e->getMessage());
        }
    }

    /**
     * Check if email already exists
     */
    public function checkEmail(Request $request)
    {
        $exists = Admin::where('email', $request->email)->exists();
        return response()->json(['exists' => $exists]);
    }
    
    /**
     * Show the form for adding a new property
     */
    public function showAddPropertyForm()
    {
        $homeTypes = HomeType::all();
        return view('admin.addproperties', compact('homeTypes'));
    }

    /**
     * Store a new property
     */
    public function storeProperty(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'beds' => 'required|integer|min:0',
            'baths' => 'required|integer|min:0',
            'sq_ft' => 'required|numeric|min:0',
            'home_type' => 'required|string|exists:hometypes,hometypes',
            'year_built' => 'required|integer|min:1800|max:' . (date('Y') + 1),
            'price_sqft' => 'required|numeric|min:0',
            'location' => 'required|string',
            'agent_name' => 'required|string',
            'more_info' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Handle main image upload
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('assets1/images'), $imageName);

            // Create the property
            $property = Property::create([
                'title' => $request->title,
                'price' => $request->price,
                'image' => $imageName,
                'beds' => $request->beds,
                'baths' => $request->baths,
                'sq_ft' => $request->sq_ft,
                'home_type' => $request->home_type,
                'year_built' => $request->year_built,
                'price_sqft' => $request->price_sqft,
                'more_info' => $request->more_info,
                'location' => $request->location,
                'agent_name' => $request->agent_name,
            ]);

            // Handle gallery images if any
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $index => $image) {
                    // Generate unique name for each gallery image
                    $galleryImageName = 'gallery_' . time() . '_' . $index . '_' . rand(1000, 9999) . '.' . $image->extension();
                    $image->move(public_path('assets1/images'), $galleryImageName);

                    // Save to prop_image table
                    PropImage::create([
                        'prop_id' => $property->id,
                        'image' => $galleryImageName,
                    ]);
                }
            }

            return redirect()->route('admin.properties')
                           ->with('success', 'Property added successfully with ' . 
                                  ($request->hasFile('gallery') ? count($request->file('gallery')) : 0) . 
                                  ' gallery images.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to add property: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing a property
     */
    public function editProperty($id)
    {
        $property = Property::findOrFail($id);
        $homeTypes = HomeType::all();
        $galleryImages = PropImage::where('prop_id', $id)->get();
        
        return view('admin.updateproperties', compact('property', 'homeTypes', 'galleryImages'));
    }

    /**
     * Update the property
     */
    public function updateProperty(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'beds' => 'required|integer|min:0',
            'baths' => 'required|integer|min:0',
            'sq_ft' => 'required|numeric|min:0',
            'home_type' => 'required|string|exists:hometypes,hometypes',
            'year_built' => 'required|integer|min:1800|max:' . (date('Y') + 1),
            'price_sqft' => 'required|numeric|min:0',
            'location' => 'required|string',
            'agent_name' => 'required|string',
            'more_info' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $property = Property::findOrFail($id);
            $hasChanges = false;
            
            // Check if main image has changed
            $imageChanged = $request->hasFile('image');
            
            // Check if any property fields have changed
            $fieldsToCheck = [
                'title', 'price', 'beds', 'baths', 'sq_ft', 'home_type', 
                'year_built', 'price_sqft', 'more_info', 'location', 'agent_name'
            ];
            
            foreach ($fieldsToCheck as $field) {
                if ($property->$field != $request->$field) {
                    $hasChanges = true;
                    break;
                }
            }
            
            // Check if gallery images were added
            $galleryChanged = $request->hasFile('gallery');
            
            // If nothing has changed, redirect with a message
            if (!$hasChanges && !$imageChanged && !$galleryChanged) {
                return redirect()->route('admin.properties')
                               ->with('info', 'No changes were made to the property.');
            }
            
            // Handle main image upload if a new one is provided
            if ($imageChanged) {
                // Delete old image if it exists
                if ($property->image && file_exists(public_path('assets1/images/' . $property->image))) {
                    unlink(public_path('assets1/images/' . $property->image));
                }
                
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('assets1/images'), $imageName);
                $property->image = $imageName;
            }

            // Update property details
            $property->title = $request->title;
            $property->price = $request->price;
            $property->beds = $request->beds;
            $property->baths = $request->baths;
            $property->sq_ft = $request->sq_ft;
            $property->home_type = $request->home_type;
            $property->year_built = $request->year_built;
            $property->price_sqft = $request->price_sqft;
            $property->more_info = $request->more_info;
            $property->location = $request->location;
            $property->agent_name = $request->agent_name;
            $property->save();

            // Handle gallery images if any
            if ($galleryChanged) {
                foreach ($request->file('gallery') as $image) {
                    $galleryImageName = 'gallery_' . time() . '_' . rand(1000, 9999) . '.' . $image->extension();
                    $image->move(public_path('assets1/images'), $galleryImageName);

                    // Save to prop_image table
                    PropImage::create([
                        'prop_id' => $property->id,
                        'image' => $galleryImageName,
                    ]);
                }
            }

            return redirect()->route('admin.properties')
                           ->with('success', 'Property updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to update property: ' . $e->getMessage());
        }
    }

    /**
     * Delete a gallery image
     */
    public function deleteGalleryImage($id)
    {
        try {
            $galleryImage = PropImage::findOrFail($id);
            
            // Delete the image file if it exists
            if ($galleryImage->image && file_exists(public_path('assets1/images/' . $galleryImage->image))) {
                unlink(public_path('assets1/images/' . $galleryImage->image));
            }
            
            // Delete the database record
            $galleryImage->delete();
            
            $propertyId = $galleryImage->prop_id;
            
            return redirect()->route('property.edit', $propertyId)
                           ->with('success', 'Gallery image deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Failed to delete gallery image: ' . $e->getMessage());
        }
    }
    
    /**
     * Show admin activity logs
     */
    public function showAdminLogs()
    {
        
        $adminLogs = DB::table('admin_logs')
                      ->orderBy('performed_at', 'desc')
                      ->simplePaginate(15); 

        // Format the date fields
        foreach ($adminLogs as $log) {
            $log->performed_at = \Carbon\Carbon::parse($log->performed_at);
        }

        // Pass the logs to the view
        return view('admin.admin_logs', compact('adminLogs'));
    }

    /**
     * Show property activity logs
     */
    public function showPropLogs()
    {
       
        $propLogs = DB::table('prop_logs')
                     ->orderBy('performed_at', 'desc')
                     ->simplePaginate(15);

        // Format the date fields
        foreach ($propLogs as $log) {
            $log->performed_at = \Carbon\Carbon::parse($log->performed_at);
        }

        // Pass the logs to the view
        return view('admin.props_logs', compact('propLogs'));
    }
    
    /**
     * Show property requests
     */
    public function showRequests()
    {
        // Get all properties with pagination
        $properties = Property::paginate(10);
        
        // Get all requests with pagination
        $requests = DB::table('requests_view')->SimplePaginate(10);
        
        // Format the date fields for requests
        foreach ($requests as $request) {
            $request->created_at = \Carbon\Carbon::parse($request->created_at);
        }
        
        return view('admin.requests', compact('properties', 'requests'));
    }
    
    /**
     * Update request status
     */
    public function updateRequestStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed',
        ]);

        try {
            DB::table('requests')
                ->where('id', $id)
                ->update(['status' => $request->status]);
            
            return redirect()->route('admin.requests')
                           ->with('success', 'Request status updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.requests')
                           ->with('error', 'Failed to update request status: ' . $e->getMessage());
        }
    }
}
    
