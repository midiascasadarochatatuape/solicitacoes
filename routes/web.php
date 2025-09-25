<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrcamentoController;

Route::get('/', [OrcamentoController::class, 'create'])->name('solicitacoes.create');
Route::get('/api/solicitacoes', [OrcamentoController::class, 'apiIndex'])->name('api.solicitacoes.index');
Route::get('/solicitacoes/concluidas', [OrcamentoController::class, 'concluidas'])->name('solicitacoes.concluidas');
Route::patch('/solicitacoes/{solicitaco}/finalizar', [OrcamentoController::class, 'finalizar'])->name('solicitacoes.finalizar');
Route::resource('solicitacoes', OrcamentoController::class)->except(['create']);

// Área administrativa (será protegida posteriormente)
// Rotas de autenticação
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/solicitacoes', [OrcamentoController::class, 'index'])->name('admin.solicitacoes.index');
});
