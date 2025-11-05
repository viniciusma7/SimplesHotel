<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TarefasController;
use Illuminate\Support\Facades\Route;

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
    Route::resource('/tarefas', TarefasController::class)->except(['show']);
    Route::post('/tarefas/{tarefa}/concluir', [TarefasController::class, 'concluir'])->name('tarefas.concluir');
    Route::post('/tarefas/{id}/restore', [TarefasController::class, 'restore'])->name('tarefas.restore');
});

require __DIR__.'/auth.php';
