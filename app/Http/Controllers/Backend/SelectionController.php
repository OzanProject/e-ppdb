<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PpdbRegistration;
use App\Models\PpdbTrack;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SelectionController extends Controller
{
    public function index(Request $request)
    {
        $school = School::first(); // Single school context
        $tracks = PpdbTrack::where('school_id', $school->id)->get();
        
        $selectedTrackId = $request->track_id ?? $tracks->first()->id ?? 0;
        $selectedTrack = PpdbTrack::find($selectedTrackId);

        $registrations = collect();
        if ($selectedTrack) {
            $registrations = PpdbRegistration::with('user')
                ->where('ppdb_track_id', $selectedTrackId)
                ->where('status', '!=', 'new') // Only process verified/accepted/rejected
                ->orderBy('rank', 'asc') // Show ranked students first
                 // If rank is null, fallback sort
                ->orderByRaw("CASE WHEN `rank` IS NULL THEN 1 ELSE 0 END") 
                ->orderByDesc('score')
                ->get();
        }

        return view('backend.selection.index', compact('school', 'tracks', 'selectedTrack', 'registrations'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'track_id' => 'required|exists:ppdb_tracks,id',
        ]);

        $track = PpdbTrack::find($request->track_id);
        
        if ($track->is_announced) {
            return redirect()->back()->with('error', 'GAGAL! Hasil seleksi jalur ini sudah diumumkan dan terkunci. Unpublish terlebih dahulu jika ingin menghitung ulang.');
        }

        // 1. Get all eligible candidates (verified + already accepted/rejected in previous runs)
        // We exclude 'new' because they are not verified yet.
        $candidates = PpdbRegistration::where('ppdb_track_id', $track->id)
            ->whereIn('status', ['verified', 'accepted', 'rejected']) 
            ->get();

        if ($candidates->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada calon siswa terverifikasi untuk diproses.');
        }

        // 2. Sorting Logic
        // If Zonasi -> Prioritize Distance (Smaller is better)
        // Else -> Prioritize Score (Larger is better)
        $isZonasi = stripos($track->name, 'Zonasi') !== false;

        $sortedCallbacks = $candidates->sort(function ($a, $b) use ($isZonasi) {
            if ($isZonasi) {
                // Distance: Ascending (Close is better)
                if ($a->distance == $b->distance) {
                    return $b->score <=> $a->score; // Tie-breaker: Score
                }
                return $a->distance <=> $b->distance;
            } else {
                // Score: Descending (High is better)
                return $b->score <=> $a->score;
            }
        });

        // 3. Update Rank & Status within Transaction
        DB::transaction(function () use ($sortedCallbacks, $track) {
            $rank = 1;
            foreach ($sortedCallbacks as $candidate) {
                $status = ($rank <= $track->quota) ? 'accepted' : 'rejected';
                
                $candidate->update([
                    'rank' => $rank,
                    'status' => $status
                ]);
                
                $rank++;
            }
        });

        return redirect()->back()->with('success', 'Proses seleksi selesai! Perankingan telah diperbarui.');
    }
}
