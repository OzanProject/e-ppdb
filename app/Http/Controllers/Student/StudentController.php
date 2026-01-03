<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PpdbRegistration;

class StudentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Load relationships safely
        $registration = PpdbRegistration::with(['track', 'school'])
                        ->where('user_id', $user->id)
                        ->latest()
                        ->first();
        
        $studentProfile = $user->studentProfile;

        // Calculate basic progress (Simplify logic for dashboard display)
        $progress = 0;
        if ($registration) {
            $progress = 100;
        } else {
             if ($studentProfile) $progress += 25; // Biodata filled
             if ($studentProfile && $studentProfile->nisn) $progress += 25; // Basic info
        }



        // Fetch Announcements (Latest published posts)
        $announcements = \App\Models\Post::where('is_published', true)
                                         ->latest('published_at')
                                         ->take(5)
                                         ->get();

        return view('frontend.student.dashboard', compact('user', 'registration', 'progress', 'studentProfile', 'announcements'));
    }



    public function editProfile()
    {
        $user = Auth::user();
        return view('frontend.student.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'avatar' => 'nullable|image|max:2048', // 2MB Max
            'current_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        // Handle Avatar Upload
        if ($request->hasFile('avatar')) {
             if ($user->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->name = $request->name;
        $user->email = $request->email;

        // Handle Password Update
        if ($request->filled('new_password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
