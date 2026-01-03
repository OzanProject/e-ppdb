<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\Frontend\FrontendController::class, 'index'])->name('home');
Route::get('/berita/{slug}', [\App\Http\Controllers\Frontend\FrontendController::class, 'showPost'])->name('news.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->hasRole(['admin', 'panitia', 'kepsek', 'bendahara'])) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('siswa')) {
            return redirect()->route('student.dashboard');
        }
        return abort(403, 'Unauthorized action.');
    })->name('dashboard');

    // Admin & Panitia Routes
    // Admin & Panitia Routes
    Route::middleware('role:admin,panitia')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Backend\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('schools', \App\Http\Controllers\Backend\SchoolController::class);
        
        Route::post('/users-destroy-multiple', [\App\Http\Controllers\Backend\UserController::class, 'destroyMultiple'])->name('users.destroy_multiple');
        Route::resource('users', \App\Http\Controllers\Backend\UserController::class);

        // PPDB Settings
        Route::prefix('ppdb')->name('ppdb.')->controller(\App\Http\Controllers\Backend\PpdbSettingController::class)->group(function() {
            Route::get('/settings', 'index')->name('settings');
            // Tracks
            Route::post('/tracks', 'storeTrack')->name('tracks.store');
            Route::put('/tracks/{track}', 'updateTrack')->name('tracks.update');
            Route::delete('/tracks/{track}', 'destroyTrack')->name('tracks.destroy');
            // Schedules
            Route::post('/schedules', 'storeSchedule')->name('schedules.store');
            Route::put('/schedules/{schedule}', 'updateSchedule')->name('schedules.update');
            Route::delete('/schedules/{schedule}', 'destroySchedule')->name('schedules.destroy');
        });

        // Registration Management
        Route::controller(\App\Http\Controllers\Backend\RegistrationController::class)->prefix('registrations')->name('registrations.')->group(function() {
            Route::get('/', 'index')->name('index');
            Route::post('/destroy-multiple', 'destroyMultiple')->name('destroy_multiple');
            Route::get('/{registration}', 'show')->name('show');
            Route::put('/{registration}', 'update')->name('update');
            Route::put('/documents/{document}', 'updateDocument')->name('documents.update');
        });

        // Selection & Ranking
        Route::controller(\App\Http\Controllers\Backend\SelectionController::class)->prefix('selection')->name('selection.')->group(function() {
            Route::get('/', 'index')->name('index');
            Route::post('/calculate', 'calculate')->name('calculate');
        });

        // Announcement
        Route::controller(\App\Http\Controllers\Backend\AnnouncementController::class)->prefix('announcements')->name('announcements.')->group(function() {
            Route::get('/', 'index')->name('index');
            Route::post('/publish', 'publish')->name('publish');
            Route::post('/unpublish', 'unpublish')->name('unpublish');
        });

        // Reports & Export
        Route::controller(\App\Http\Controllers\Backend\ReportController::class)->prefix('reports')->name('reports.')->group(function() {
            Route::get('/', 'index')->name('index');
            Route::post('/excel', 'exportExcel')->name('excel');
            Route::post('/print', 'printView')->name('print');
        });

        // Activity Logs
        Route::get('/logs', [\App\Http\Controllers\Backend\LogController::class, 'index'])->name('logs.index');
        Route::post('/logs/destroy-multiple', [\App\Http\Controllers\Backend\LogController::class, 'destroyMultiple'])->name('logs.destroy_multiple');
        Route::delete('/logs', [\App\Http\Controllers\Backend\LogController::class, 'destroy'])->name('logs.destroy');

        // CMS Routes
        Route::resource('posts', \App\Http\Controllers\Backend\PostController::class);
        Route::resource('faqs', \App\Http\Controllers\Backend\FaqController::class);
    });

    // Siswa Routes
    Route::middleware('role:siswa')->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Student\StudentController::class, 'index'])->name('dashboard');
        Route::get('/profile', [\App\Http\Controllers\Student\StudentController::class, 'editProfile'])->name('profile');
        Route::put('/profile', [\App\Http\Controllers\Student\StudentController::class, 'updateProfile'])->name('profile.update');


        Route::prefix('registration')->name('registration.')->controller(\App\Http\Controllers\Student\RegistrationController::class)->group(function() {
            Route::get('/step-1', 'step1')->name('step1');
            Route::post('/step-1', 'storeStep1')->name('storeStep1');
            
            // To be added: step 2, 3, 4
            Route::get('/step-2', 'step2')->name('step2');
            Route::post('/step-2', 'storeStep2')->name('storeStep2');
            
            Route::get('/step-3', 'step3')->name('step3');
            Route::post('/step-3', 'storeStep3')->name('storeStep3');

            Route::get('/step-4', 'step4')->name('step4');
            Route::post('/step-4', 'storeStep4')->name('storeStep4');

            Route::get('/step-5', 'step5')->name('step5');
            Route::post('/step-5', 'storeStep5')->name('storeStep5');

            Route::get('/print', 'printRegistration')->name('print');
            Route::get('/print-card', 'printExamineeCard')->name('print_card');
            Route::get('/print-acceptance', 'printAcceptance')->name('print_acceptance');
        });

        Route::post('/documents', [\App\Http\Controllers\Student\DocumentController::class, 'store'])->name('documents.store');
    });
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
