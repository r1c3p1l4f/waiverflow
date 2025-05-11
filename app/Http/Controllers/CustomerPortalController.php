<?php

namespace App\Http\Controllers;

use App\Models\CustomerProfile;
use App\Models\WaiverTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerPortalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function dashboard()
    {
        $user = Auth::user();
        $recentWaivers = $user->signedWaivers()
            ->with('waiverTemplate')
            ->latest('signed_at')
            ->take(5)
            ->get();
            
        return view('customer.dashboard', [
            'user' => $user,
            'recentWaivers' => $recentWaivers
        ]);
    }
    
    public function profile()
    {
        $user = Auth::user();
        $profile = $user->customerProfile ?? new CustomerProfile();
        
        return view('customer.profile', [
            'user' => $user,
            'profile' => $profile
        ]);
    }
    
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
        ]);
        
        if ($user->customerProfile) {
            $user->customerProfile->update($validated);
        } else {
            $user->customerProfile()->create($validated);
        }
        
        return redirect()->route('customer.profile')
            ->with('success', 'Profile updated successfully');
    }
    
    public function waivers()
    {
        $waivers = Auth::user()->signedWaivers()
            ->with('waiverTemplate')
            ->latest('signed_at')
            ->paginate(10);
            
        return view('customer.waivers', compact('waivers'));
    }
    
    public function availableWaivers()
    {
        $templates = WaiverTemplate::where('is_active', true)
            ->orderBy('name')
            ->get();
            
        return view('customer.available-waivers', compact('templates'));
    }
}
