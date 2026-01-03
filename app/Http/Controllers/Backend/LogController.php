<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('causer')->latest();

        if ($request->has('search') && $request->search != '') {
            $query->where('description', 'like', '%' . $request->search . '%')
                  ->orWhereHas('causer', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }

        $logs = $query->paginate(20);

        return view('backend.logs.index', compact('logs'));
    }
    public function destroy()
    {
        // Check if user is Admin (Panitia should not be able to clear logs)
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        Activity::truncate();

        // Optional: Log this action specifically (it will be the first new log)
        activity()
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('All system logs have been cleared.');

        return redirect()->route('admin.logs.index')->with('success', 'Semua log aktivitas berhasil dihapus.');
    }
    public function destroyMultiple(Request $request)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $request->validate([
            'ids' => 'required|string', // JSON string
        ]);

        $ids = json_decode($request->ids, true);

        if (is_array($ids) && count($ids) > 0) {
            Activity::whereIn('id', $ids)->delete();

            activity()
                ->causedBy(auth()->user())
                ->withProperties(['count' => count($ids)])
                ->log('Bulk deleted system logs.');

            return redirect()->route('admin.logs.index')->with('success', 'Log terpilih berhasil dihapus.');
        }

        return redirect()->route('admin.logs.index')->with('error', 'Tidak ada log yang dipilih.');
    }
}
