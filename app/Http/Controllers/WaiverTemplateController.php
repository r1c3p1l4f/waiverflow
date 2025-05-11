<?php

namespace App\Http\Controllers;

use App\Models\WaiverTemplate;
use Illuminate\Http\Request;

class WaiverTemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin'])->except(['index', 'show']);
    }

    public function index()
    {
        $templates = WaiverTemplate::where('is_active', true)
            ->orderBy('name')
            ->get();
            
        return view('waiver-templates.index', compact('templates'));
    }

    public function create()
    {
        return view('waiver-templates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|json',
            'is_active' => 'boolean',
        ]);

        $template = WaiverTemplate::create([
            'name' => $validated['name'],
            'content' => json_decode($validated['content'], true),
            'is_active' => $validated['is_active'] ?? true,
            'version' => 1,
        ]);

        return redirect()->route('waiver-templates.show', $template)
            ->with('success', 'Waiver template created successfully');
    }

    public function show(WaiverTemplate $waiverTemplate)
    {
        return view('waiver-templates.show', [
            'template' => $waiverTemplate
        ]);
    }

    public function edit(WaiverTemplate $waiverTemplate)
    {
        return view('waiver-templates.edit', [
            'template' => $waiverTemplate
        ]);
    }

    public function update(Request $request, WaiverTemplate $waiverTemplate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|json',
            'is_active' => 'boolean',
        ]);

        // Increment version when content changes
        $newVersion = $waiverTemplate->version;
        if ($waiverTemplate->content != json_decode($validated['content'], true)) {
            $newVersion++;
        }

        $waiverTemplate->update([
            'name' => $validated['name'],
            'content' => json_decode($validated['content'], true),
            'is_active' => $validated['is_active'] ?? $waiverTemplate->is_active,
            'version' => $newVersion,
        ]);

        return redirect()->route('waiver-templates.show', $waiverTemplate)
            ->with('success', 'Waiver template updated successfully');
    }

    public function destroy(WaiverTemplate $waiverTemplate)
    {
        // Soft delete by setting inactive rather than removing
        $waiverTemplate->update(['is_active' => false]);
        
        return redirect()->route('waiver-templates.index')
            ->with('success', 'Waiver template deactivated');
    }
}
