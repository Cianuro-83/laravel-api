<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Mail\NewLead;
use App\Models\Lead;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
    Route::post('/projects/{project:slug}/restore', [ProjectController::class, 'restore'])->name('projects.restore')->withTrashed();

    Route::resource('projects', ProjectController::class)->parameters(['projects' => 'project:slug'])->withTrashed(['show', 'edit', 'update', 'destroy']);

    Route::delete('/projects', [ProjectController::class, 'destroyAll'])->name('projects.destroy.all');


});

require __DIR__.'/auth.php';

Route::get('/new-lead-mail', function () {

    $lead = Lead::first();

    return new NewLead($lead);
});