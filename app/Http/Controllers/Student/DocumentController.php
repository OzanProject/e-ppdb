<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class DocumentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function store(Request $request)
    {
        // Security Review: Validate Uploads
        // Enforce max size 2MB and specific mimes
        $request->validate([
            'document_type' => 'required|in:kk,akta,ijazah,foto',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', 
            'registration_id' => 'required|exists:ppdb_registrations,id'
        ]);

        $user = auth()->user();
        $registration = $user->ppdbRegistration;

        if (!$registration || $registration->id != $request->registration_id) {
            return abort(403, 'Unauthorized action.');
        }

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('documents', 'public');

            // Find existing or create new doc
            $document = StudentDocument::updateOrCreate(
                [
                    'ppdb_registration_id' => $registration->id,
                    'type' => $request->document_type
                ],
                [
                    'file_path' => $path,
                    'status' => 'pending', // Reset status on new upload
                    'feedback' => null
                ]
            );
            
            // Log manually if needed, though model events might handle it if setup on StudentDocument
            activity()
               ->performedOn($document)
               ->causedBy($user)
               ->log('uploaded_document');

            return redirect()->back()->with('success', 'Dokumen berhasil diupload.');
        }

        return redirect()->back()->with('error', 'Gagal mengupload file.');
    }
}
