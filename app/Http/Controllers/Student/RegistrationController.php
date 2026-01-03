<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentProfile;

class RegistrationController extends Controller
{
    public function step1()
    {
        $user = Auth::user();
        $studentProfile = $user->studentProfile;
        
        return view('frontend.student.registration.step1', compact('studentProfile'));
    }

    public function step2()
    {
        $user = Auth::user();
        if (!$user->studentProfile) {
            return redirect()->route('student.registration.step1')->with('error', 'Silakan lengkapi Data Pribadi terlebih dahulu.');
        }

        $studentProfile = $user->studentProfile;
        $parentInfo = \App\Models\ParentInfo::where('user_id', $user->id)->first();

        return view('frontend.student.registration.step2', compact('studentProfile', 'parentInfo'));
    }

    public function step3()
    {
        $user = Auth::user();
        if (!$user->studentProfile) {
            return redirect()->route('student.registration.step1');
        }
        // Ideally check parent info too, but studentProfile is the main anchor
        
        $studentProfile = $user->studentProfile;
        $grades = \App\Models\StudentGrade::where('user_id', $user->id)
                    ->pluck('score', 'subject')
                    ->toArray();

        return view('frontend.student.registration.step3', compact('studentProfile', 'grades'));
    }

    public function step4()
    {
        $user = Auth::user();
        if (!$user->studentProfile) {
            return redirect()->route('student.registration.step1');
        }

        $studentProfile = $user->studentProfile;
        $documents = \App\Models\StudentDocument::where('user_id', $user->id)->get()->keyBy('type');

        return view('frontend.student.registration.step4', compact('studentProfile', 'documents'));
    }

    public function step5()
    {
        $user = Auth::user();
        if (!$user->studentProfile) {
            return redirect()->route('student.registration.step1');
        }

        $studentProfile = $user->studentProfile;
        // Check if mandatory documents are uploaded? Optional but good UX.
        
        $activeTracks = \App\Models\PpdbTrack::where('is_active', true)->get();
        $documents = \App\Models\StudentDocument::where('user_id', $user->id)->get();

        return view('frontend.student.registration.step5', compact('studentProfile', 'activeTracks', 'documents'));
    }

    public function storeStep5(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'track_id' => 'required|exists:ppdb_tracks,id',
            'declaration' => 'required|accepted',
        ]);

        // Generate Registration Code: REG-YYYY-RANDOM
        $regCode = 'REG-' . date('Y') . '-' . strtoupper(\Illuminate\Support\Str::random(6));

        // Calculate Average Score
        $grades = \App\Models\StudentGrade::where('user_id', $user->id)->pluck('score');
        $averageScore = $grades->count() > 0 ? $grades->avg() : 0;

        $registration = \App\Models\PpdbRegistration::create([
            'user_id' => $user->id,
            'school_id' => \App\Models\School::first()->id, 
            'ppdb_track_id' => $request->track_id,
            'registration_code' => $regCode,
            'status' => 'new',
            'score' => $averageScore, // Save calculated score
        ]);

        // Link Documents to Registration
        // This ensures they show up in Admin Panel via $registration->documents
        \App\Models\StudentDocument::where('user_id', $user->id)
            ->whereNull('ppdb_registration_id') // Only link unlinked ones
            ->update(['ppdb_registration_id' => $registration->id]);

        // Send Email Notification
        try {
            $user->notify(new \App\Notifications\RegistrationSubmitted($registration));
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Illuminate\Support\Facades\Log::error('Email Error: ' . $e->getMessage());
        }

        return redirect()->route('student.dashboard')->with('success', 'Pendaftaran BERHASIL! Silakan tunggu verifikasi admin.');
    }
    public function printRegistration()
    {
        $user = Auth::user();
        $registration = \App\Models\PpdbRegistration::where('user_id', $user->id)
            ->with(['school', 'track', 'user.studentProfile'])
            ->latest()
            ->firstOrFail();

        return view('frontend.student.registration.print_registration', compact('registration'));
    }

    public function printExamineeCard()
    {
         $user = Auth::user();
         $registration = \App\Models\PpdbRegistration::where('user_id', $user->id)
            ->whereIn('status', ['verified', 'accepted']) // Must be verified
            ->with(['school', 'track', 'user.studentProfile'])
            ->latest()
            ->firstOrFail();

        return view('frontend.student.registration.print_examinee_card', compact('registration'));
    }
    public function printAcceptance()
    {
         $user = Auth::user();
         $registration = \App\Models\PpdbRegistration::where('user_id', $user->id)
            ->where('status', 'accepted') // STRICTLY only for accepted students
            ->with(['school', 'track', 'user.studentProfile'])
            ->latest()
            ->firstOrFail();

        // Security: Prevent accessing acceptance letter if announcement is not yet published
        if (!($registration->track->is_announced ?? false)) {
            abort(403, 'Pengumuman belum diterbitkan.');
        }

        return view('frontend.student.registration.print_acceptance', compact('registration'));
    }
}
