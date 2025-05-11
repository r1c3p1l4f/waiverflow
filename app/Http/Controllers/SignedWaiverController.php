<?php

namespace App\Http\Controllers;

use App\Models\SignedWaiver;
use App\Models\WaiverTemplate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SignedWaiverController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('staff')) {
            $waivers = SignedWaiver::with(['user', 'waiverTemplate'])
                ->latest('signed_at')
                ->paginate(15);
        } else {
            $waivers = Auth::user()->signedWaivers()
                ->with('waiverTemplate')
                ->latest('signed_at')
                ->paginate(15);
        }
        
        return view('signed-waivers.index', compact('waivers'));
    }

    public function create(Request $request)
    {
        $templateId = $request->query('template_id');
        $template = WaiverTemplate::findOrFail($templateId);
        
        return view('signed-waivers.create', [
            'template' => $template,
            'user' => Auth::user()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'waiver_template_id' => 'required|exists:waiver_templates,id',
            'signed_content' => 'required|json',
            'signature_data' => 'required|string',
        ]);

        $waiver = SignedWaiver::create([
            'user_id' => Auth::id(),
            'waiver_template_id' => $validated['waiver_template_id'],
            'signed_content' => json_decode($validated['signed_content'], true),
            'signature_data' => $validated['signature_data'],
            'ip_address' => $request->ip(),
            'signed_at' => now(),
            // Set expiration if needed
            'expires_at' => null,
        ]);

        return redirect()->route('signed-waivers.show', $waiver)
            ->with('success', 'Waiver signed successfully');
    }

    public function show(SignedWaiver $signedWaiver)
    {
        $this->authorize('view', $signedWaiver);
        
        return view('signed-waivers.show', [
            'waiver' => $signedWaiver
        ]);
    }

    public function download(SignedWaiver $signedWaiver)
    {
        $this->authorize('view', $signedWaiver);
        
        $pdf = PDF::loadView('signed-waivers.pdf', [
            'waiver' => $signedWaiver
        ]);
        
        return $pdf->download('waiver-' . $signedWaiver->id . '.pdf');
    }
}
