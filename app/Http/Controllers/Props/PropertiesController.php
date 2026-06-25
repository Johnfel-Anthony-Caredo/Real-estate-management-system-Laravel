<?php

namespace App\Http\Controllers\Props;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prop\Property;
use App\Models\Prop\PropImage;
use App\Models\Prop\AllRequest;
use App\Models\Prop\SavedProp;
use App\Models\Prop\HomeType;
use Auth;

class PropertiesController extends Controller
{
    public function index() {
        $props = Property::latest()->paginate(9);
        return view('home', compact('props'));
    }
    
    public function searchProperties(Request $request) {
        $request->validate([
            'home_type' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:200'],
        ]);

        $query = Property::query();
        
        if ($request->filled('home_type')) {
            $query->where('home_type', $request->home_type);
        }
        
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        
        $props = $query->latest()->paginate(9)->withQueryString();
        
        return view('home', compact('props'));
    }

    public function single($id) {
        $singleProp = Property::findOrFail($id);

        $propImages = PropImage::where('prop_id', $id)->get();

        $relatedProps = Property::where('home_type', $singleProp->home_type)->where('id', '!=', $id)->take(3)->orderBy('created_at', 'desc')->get();

        //request 

if (auth()->check()) { // Use check() for better readability
    $userId = Auth::id(); // Store the user ID for reuse

    $validateFormCount = AllRequest::where('prop_id', $id)
        ->where('user_id', $userId)
        ->count();

    // Validating saving props
    $validateSavingPropsCount = SavedProp::where('prop_id', $id)
        ->where('user_id', $userId)
        ->count();

    return view('props.single', compact('singleProp', 'propImages', 'relatedProps', 'validateFormCount', 'validateSavingPropsCount'));
} else {
    return view('props.single', compact('singleProp', 'propImages', 'relatedProps'));
}

    }

    public function insertRequests(Request $request, $id) {
        $property = Property::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100'],
            'phone' => ['required', 'string', 'min:7', 'max:30'],
        ]);

        $existingRequest = AllRequest::where('prop_id', $property->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($existingRequest) {
            return redirect()->route('single.prop', $property->id)
                ->with('info', 'You already sent a request for this property.');
        }

        AllRequest::create([
            "prop_id" => $property->id,
            "agent_name" => $property->agent_name,
            "user_id" => Auth::id(),
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,

        ]); 
     
        return redirect()->route('single.prop', $property->id)->with('success', 'Your property request was sent.');
        

    }

    public function saveProps(Request $request, $id) {
        $property = Property::findOrFail($id);

        $alreadySaved = SavedProp::where('prop_id', $property->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($alreadySaved) {
            return redirect()->route('single.prop', $property->id)->with('info', 'This property is already saved.');
        }

        SavedProp::create([
            'prop_id' => $property->id,
            'user_id' => Auth::id(),
            'title' => $property->title,
            'image' => $property->image,
            'location' => $property->location,
            'price' => $property->price,
        ]);

        return redirect()->route('single.prop', $property->id)->with('success', 'Property saved successfully.');
    }



    public function displayByHomeType($hometype) {
        $propsByHomeType = Property::where('home_type', $hometype)->latest()->paginate(9);

        return view('props.propshometype', compact('propsByHomeType', 'hometype')); 
    }

    public function showRequests()
    {
        $requests = AllRequest::where('user_id', Auth::id())
            ->with('property')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('props.request', compact('requests'));
    }

    public function cancelRequest($id)
    {
        try {
            $request = AllRequest::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
                
            $request->delete();
            
            return redirect()->route('user.requests')
                           ->with('success', 'Request cancelled successfully.');
        } catch (\Exception $e) {
            return redirect()->route('user.requests')
                           ->with('error', 'Failed to cancel request.');
        }
    }

    public function showSavedProps()
    {
        $savedProps = SavedProp::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('props.saved', compact('savedProps'));
    }

    public function removeSavedProp($id)
    {
        try {
            $savedProp = SavedProp::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
                
            $savedProp->delete();
            
            return redirect()->route('user.saved.properties')
                           ->with('success', 'Property removed from saved list.');
        } catch (\Exception $e) {
            return redirect()->route('user.saved.properties')
                           ->with('error', 'Failed to remove property.');
        }
    }
}
