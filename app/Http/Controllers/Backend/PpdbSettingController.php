<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PpdbSchedule;
use App\Models\PpdbTrack;
use App\Models\School;
use Illuminate\Http\Request;

class PpdbSettingController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        // Assuming single school context for now, or pick the first active school logic
        // For multi-school admin, we might need a selector. For now context is global $school_data provider?
        // Let's assume the user is managing the "active" school from the session or first available.
        
        // Strategy: Get the School ID from the View Composer shared data if possible, or query.
        // Since we are not strictly using session for school_id yet, let's fetch the first school for now as a default
        // or ensure the sidebar logic's school is used.
        
        $school = School::first(); // Should be refined later for Multi-tenancy
        
        if (!$school) {
            return redirect()->route('admin.schools.create')->with('error', 'Silakan buat data sekolah terlebih dahulu.');
        }

        $tracks = $school->ppdbTracks()->orderBy('name')->get();
        $schedules = $school->ppdbSchedules()->orderBy('start_date')->get();

        return view('backend.ppdb.settings', compact('school', 'tracks', 'schedules'));
    }

    // --- TRACK METHODS ---

    public function storeTrack(Request $request)
    {
        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'name' => 'required|string|max:255',
            'quota' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        PpdbTrack::create($validated);

        return redirect()->back()->with('success', 'Jalur PPDB berhasil ditambahkan.');
    }

    public function updateTrack(Request $request, PpdbTrack $track)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quota' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $track->update($validated);

        return redirect()->back()->with('success', 'Jalur PPDB berhasil diperbarui.');
    }

    public function destroyTrack(PpdbTrack $track)
    {
        $track->delete();
        return redirect()->back()->with('success', 'Jalur PPDB berhasil dihapus.');
    }

    // --- SCHEDULE METHODS ---

    public function storeSchedule(Request $request)
    {
        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'activity' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $validated['is_active'] = $request->has('is_active');

        PpdbSchedule::create($validated);

        return redirect()->back()->with('success', 'Jadwal kegiatan berhasil ditambahkan.');
    }

    public function updateSchedule(Request $request, PpdbSchedule $schedule)
    {
        $validated = $request->validate([
            'activity' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $schedule->update($validated);

        return redirect()->back()->with('success', 'Jadwal kegiatan berhasil diperbarui.');
    }

    public function destroySchedule(PpdbSchedule $schedule)
    {
        $schedule->delete();
        return redirect()->back()->with('success', 'Jadwal kegiatan berhasil dihapus.');
    }
}
