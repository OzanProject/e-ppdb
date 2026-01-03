<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PpdbRegistration;
use App\Models\PpdbTrack;
use App\Models\School;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $school = School::first();
        $tracks = PpdbTrack::where('school_id', $school->id)->get();
        
        return view('backend.reports.index', compact('school', 'tracks'));
    }

    public function exportExcel(Request $request)
    {
        $request->validate(['track_id' => 'required|exists:ppdb_tracks,id']);
        
        $track = PpdbTrack::find($request->track_id);
        
        // Fetch accepted students for the track
        $registrations = PpdbRegistration::with(['user', 'user.studentProfile'])
            ->where('ppdb_track_id', $track->id)
            ->where('status', 'accepted')
            ->orderBy('rank', 'asc')
            ->get();

        if ($registrations->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data siswa lolos untuk diexport pada jalur ini.');
        }

        $filename = 'Laporan_Kelulusan_' . str_replace(' ', '_', $track->name) . '_' . date('Y-m-d') . '.xlsx';

        // Stream download using FastExcel
        return (new FastExcel($registrations))->download($filename, function ($reg) {
            return [
                'Peringkat' => $reg->rank,
                'No. Pendaftaran' => $reg->registration_code,
                'Nama Siswa' => $reg->user->name,
                'NISN' => $reg->user->studentProfile->nisn ?? '-',
                'Asal Sekolah' => $reg->user->studentProfile->school_origin ?? '-',
                'Jenis Kelamin' => $reg->user->studentProfile->gender ?? '-',
                'Nilai Akhir' => $reg->score,
                'Jarak (m)' => $reg->distance ?? '-',
            ];
        });
    }

    public function printView(Request $request)
    {
        $request->validate(['track_id' => 'required|exists:ppdb_tracks,id']);
        
        $track = PpdbTrack::find($request->track_id);
        $school = School::first();

        $registrations = PpdbRegistration::with(['user', 'user.studentProfile'])
            ->where('ppdb_track_id', $track->id)
            ->where('status', 'accepted')
            ->orderBy('rank', 'asc')
            ->get();

        if ($registrations->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data siswa lolos untuk dicetak.');
        }

        return view('backend.reports.print', compact('school', 'track', 'registrations'));
    }
}
