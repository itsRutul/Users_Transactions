<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DataTableController;

Route::get ('/register', [UserController::class, 'showRegistrationForm'])->name('register.show');
Route::post('/register', [UserController::class, 'store'])->name('register.store');
Route::get('/data-table', [DataTableController::class, 'index'])->name('data-table.index');
Route::get('user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::resource('users', UserController::class);
Route::post('users/{user}/transaction', [UserController::class, 'storeTransaction'])->name('transaction.store');
Route::get('users/{user}/transaction/create', [TransactionController::class, 'create'])->name('transaction.create');
Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');









