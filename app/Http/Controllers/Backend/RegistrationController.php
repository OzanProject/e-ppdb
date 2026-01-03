<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PpdbRegistration;
use App\Models\PpdbTrack;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PpdbRegistration::with(['user', 'track']);

        // Filters
        if ($request->has('track_id') && $request->track_id != '') {
            $query->where('ppdb_track_id', $request->track_id);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Search by Name or Registration Code
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('registration_code', 'like', "%{$search}%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Default Sort: 'new' status first, then latest
        $registrations = $query->orderByRaw("CASE WHEN status = 'new' THEN 1 ELSE 0 END DESC")
                               ->latest()
                               ->paginate(10);
        $tracks = PpdbTrack::all(); // Assuming single school context for now, ideally filter by school

        return view('backend.registrations.index', compact('registrations', 'tracks'));
    }

    /**
     * Display the specified resource.
     */
    public function show(PpdbRegistration $registration)
    {
        $registration->load(['user.studentProfile', 'track', 'school', 'documents']);
        return view('backend.registrations.show', compact('registration'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PpdbRegistration $registration)
    {
        if ($registration->track->is_announced) {
            return redirect()->back()->with('error', 'GAGAL! Jalur ini sudah diumumkan. Status siswa tidak dapat diubah.');
        }

        // This might be used for quick status update or notes
        $validated = $request->validate([
            'status' => 'required|in:new,verified,rejected,accepted',
            'notes' => 'nullable|string',
        ]);

        // Check if status actually changed
        $oldStatus = $registration->status;
        
        $registration->update($validated);

        // Send Email Notification if status changed
        if ($oldStatus !== $validated['status']) {
            try {
                // Ensure notification class is imported or fully qualified
                $registration->user->notify(new \App\Notifications\RegistrationStatusUpdated($validated['status'], $validated['notes'] ?? null));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Notifikasi Email Gagal: ' . $e->getMessage());
                // Fallback success message
                return redirect()->back()->with('success', 'Status diperbarui (Email gagal terkirim).');
            }
        }

        return redirect()->back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    /**
     * Update Document Status
     */
    public function updateDocument(Request $request, \App\Models\StudentDocument $document)
    {
        $validated = $request->validate([
            'status' => 'required|in:valid,invalid',
            'feedback' => 'nullable|string',
        ]);

        $document->update($validated);

        return redirect()->back()->with('success', 'Status dokumen berhasil diperbarui.');
    }

    /**
     * Remove the specified resources from storage.
     */
    public function destroyMultiple(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:ppdb_registrations,id',
        ]);

        $registrations = PpdbRegistration::with('documents')->whereIn('id', $request->ids)->get();

        foreach ($registrations as $registration) {
            // Delete physical files
            foreach ($registration->documents as $doc) {
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($doc->file_path)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($doc->file_path);
                }
            }
            // Registration delete will cascade/delete document records from DB (if FK set correctly)
            // But to be safe and explicit, or if we want to rely on Model events:
            $registration->delete(); 
        }

        return redirect()->back()->with('success', 'Data pendaftar dan dokumen fisik berhasil dibersihkan.');
    }
}
