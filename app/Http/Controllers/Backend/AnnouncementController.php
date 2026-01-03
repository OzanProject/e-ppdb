<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PpdbTrack;
use App\Models\School;
use App\Models\PpdbRegistration;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $school = School::first();
        
        if (!$school) {
            return redirect()->route('admin.dashboard')->with('error', 'Data sekolah belum diatur.');
        }

        $tracks = PpdbTrack::where('school_id', $school->id)->get();
        
        if ($tracks->isEmpty()) {
             return view('backend.announcements.index', compact('school', 'tracks'))->with('warning', 'Belum ada jalur pendaftaran.');
        }

        $selectedTrackId = $request->track_id ?? $tracks->first()->id;
        $selectedTrack = PpdbTrack::find($selectedTrackId);

        // Fallback if selected track not found
        if (!$selectedTrack && $tracks->isNotEmpty()) {
            $selectedTrack = $tracks->first();
            $selectedTrackId = $selectedTrack->id;
        }

        $registrations = collect();
        if ($selectedTrack) {
            $registrations = PpdbRegistration::with(['user.studentProfile'])
                ->where('ppdb_track_id', $selectedTrackId)
                ->where('status', 'accepted') // Only show accepted students
                ->orderBy('rank', 'asc')
                ->get();
        }

        return view('backend.announcements.index', compact('school', 'tracks', 'selectedTrack', 'registrations'));
    }

    public function publish(Request $request)
    {
        $request->validate([
            'track_id' => 'required|exists:ppdb_tracks,id',
        ]);

        $track = PpdbTrack::find($request->track_id);
        $track->update(['is_announced' => true]);

        return redirect()->back()->with('success', 'Pengumuman untuk jalur ' . $track->name . ' BERHASIL DIPUBLIKASIKAN! Data sekarang terkunci.');
    }

    public function unpublish(Request $request)
    {
        $request->validate([
            'track_id' => 'required|exists:ppdb_tracks,id',
        ]);

        $track = PpdbTrack::find($request->track_id);
        
        // Safety check: Only allow unpublish if authenticated user is explicitly allowed (skipped for now, but good practice)
        $track->update(['is_announced' => false]);

        return redirect()->back()->with('success', 'Pengumuman DIBATALKAN. Data jalur ini terbuka kembali untuk edit.');
    }
}
