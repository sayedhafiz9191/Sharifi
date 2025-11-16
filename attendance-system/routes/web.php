<?php

use App\Http\Controllers\ExpenseController;
use Illuminate\Support\Facades\Route;

Route::post('/expenses/create', [ExpenseController::class, 'createExpense']);
Route::get('/expenses/all', [ExpenseController::class, 'getAllExpenses']);
Route::delete('/expenses/delete/{id}', [ExpenseController::class, 'deleteExpense']);
