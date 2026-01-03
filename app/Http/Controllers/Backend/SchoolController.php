<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schools = School::latest()->get();
        return view('backend.schools.index', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.schools.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'jenjang' => 'required|in:sd,smp,sma,smk',
            'alamat' => 'required|string',
            'tahun_ajaran' => 'required|string|max:20',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'social_media' => 'nullable|array',
            'district' => 'nullable|string|max:100',
            'headmaster_name' => 'nullable|string|max:255',
            'headmaster_nip' => 'nullable|string|max:50',
            'accreditation' => 'nullable|string|max:5',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('schools', 'public');
            $validated['logo'] = $path;
        }

        if ($request->hasFile('hero_image')) {
            $path = $request->file('hero_image')->store('schools/hero', 'public');
            $validated['hero_image'] = $path;
        }

        if ($request->filled('social_media')) {
             $validated['social_media'] = array_values($request->input('social_media'));
        }

        School::create($validated);

        return redirect()->route('admin.schools.index')->with('success', 'Data sekolah berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school)
    {
        return view('backend.schools.edit', compact('school'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, School $school)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'jenjang' => 'required|in:sd,smp,sma,smk',
            'alamat' => 'required|string',
            'tahun_ajaran' => 'required|string|max:20',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'social_media' => 'nullable|array',
            'social_media.*.platform' => 'required_with:social_media|string',
            'social_media.*.url' => 'required_with:social_media|url',
            'district' => 'nullable|string|max:100',
            'headmaster_name' => 'nullable|string|max:255',
            'headmaster_nip' => 'nullable|string|max:50',
            'accreditation' => 'nullable|string|max:5',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($school->logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($school->logo)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($school->logo);
            }
            $path = $request->file('logo')->store('schools', 'public');
            $validated['logo'] = $path;
        }

        if ($request->hasFile('hero_image')) {
            // Delete old hero image
            if ($school->hero_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($school->hero_image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($school->hero_image);
            }
            $path = $request->file('hero_image')->store('schools/hero', 'public');
            $validated['hero_image'] = $path;
        }

        // Explicitly handle social_media to ensure array values (reset keys) and null if empty
        if ($request->filled('social_media')) {
             $validated['social_media'] = array_values($request->input('social_media'));
        } else {
             $validated['social_media'] = null;
        }

        $school->update($validated);

        return redirect()->route('admin.schools.index')->with('success', 'Data sekolah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        if ($school->logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($school->logo)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($school->logo);
        }
        
        $school->delete();
        return redirect()->route('admin.schools.index')->with('success', 'Data sekolah berhasil dihapus.');
    }
}
