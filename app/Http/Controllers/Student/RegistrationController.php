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

    public function storeStep1(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'nisn' => 'required|numeric|digits:10',
            'gender' => 'required|in:L,P',
            'place_of_birth' => 'required|string|max:100',
            'date_of_birth' => 'required|date',
            'phone' => 'required|string|max:20',
        ]);

        StudentProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nisn' => $validated['nisn'],
                'gender' => $validated['gender'],
                'birth_place' => $validated['place_of_birth'],
                'birth_date' => $validated['date_of_birth'],
                'phone' => $validated['phone'],
            ]
        );

        return redirect()->route('student.registration.step2');
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

    public function storeStep2(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'address' => 'required|string|max:500',
            'father_name' => 'required|string|max:255',
            'father_job' => 'required|string|max:255',
            'father_phone' => 'required|string|max:20',
            'mother_name' => 'required|string|max:255',
            'mother_job' => 'required|string|max:255',
            'mother_phone' => 'required|string|max:20',
            'address_parent' => 'nullable|string|max:500',
        ]);

        // Update Address in StudentProfile
        \App\Models\StudentProfile::updateOrCreate(
            ['user_id' => $user->id],
            ['address' => $validated['address']]
        );

        // Update Parent Info
        \App\Models\ParentInfo::updateOrCreate(
            ['user_id' => $user->id],
            [
                'father_name' => $validated['father_name'],
                'father_job' => $validated['father_job'],
                'father_phone' => $validated['father_phone'],
                'mother_name' => $validated['mother_name'],
                'mother_job' => $validated['mother_job'],
                'mother_phone' => $validated['mother_phone'],
                'address_parent' => $validated['address_parent'] ?? $validated['address'], // Default to same address if empty
            ]
        );

        return redirect()->route('student.registration.step3');
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

    public function storeStep3(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'school_origin' => 'required|string|max:255',
            'npsn_origin' => 'required|numeric|digits:8', 
            'graduation_year' => 'required|digits:4|integer|min:'.(date('Y')-5).'|max:'.date('Y'),
            'grades' => 'required|array',
            'grades.indonesia' => 'required|numeric|min:0|max:100',
            'grades.inggris' => 'required|numeric|min:0|max:100',
            'grades.matematika' => 'required|numeric|min:0|max:100',
            'grades.ipa' => 'required|numeric|min:0|max:100',
        ]);

        \App\Models\StudentProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'school_origin' => $validated['school_origin'],
                'npsn_origin' => $validated['npsn_origin'],
                'graduation_year' => $validated['graduation_year'],
            ]
        );

        foreach ($validated['grades'] as $subject => $score) {
            \App\Models\StudentGrade::updateOrCreate(
                ['user_id' => $user->id, 'subject' => $subject],
                ['score' => $score]
            );
        }

        return redirect()->route('student.registration.step4');
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

    public function storeStep4(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'akta' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ijazah' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'foto' => 'nullable|image|max:2048',
        ]);

        $types = ['kk', 'akta', 'ijazah', 'foto'];

        foreach ($types as $type) {
            if ($request->hasFile($type)) {
                // Delete old file if exists
                $existingDoc = \App\Models\StudentDocument::where('user_id', $user->id)->where('type', $type)->first();
                if ($existingDoc && \Illuminate\Support\Facades\Storage::disk('public')->exists($existingDoc->file_path)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($existingDoc->file_path);
                }

                $path = $request->file($type)->store('documents/' . $user->id, 'public');

                \App\Models\StudentDocument::updateOrCreate(
                    ['user_id' => $user->id, 'type' => $type],
                    [
                        'file_path' => $path,
                        'status' => 'pending' // Reset status on re-upload
                    ]
                );
            }
        }
        
        // Check if mandatory files exist (e.g., KK and Akta are mandatory)
        // You can enforce this check here or just rely on validation if 'required' was used (but file inputs cleared on error, so DB check is better)
        
        return redirect()->route('student.registration.step5');
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
