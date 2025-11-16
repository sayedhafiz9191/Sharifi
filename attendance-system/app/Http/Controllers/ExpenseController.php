<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Store a newly created expense in storage.
     */
    public function createExpense(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'between:0,9999999.99'],
            'date' => ['required', 'date'],
            'category' => ['nullable', 'string', 'max:255'],
        ]);

        $expense = Expense::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Expense recorded successfully.',
            'data' => $expense,
        ], 201);
    }

    /**
     * Display a listing of the expenses.
     */
    public function getAllExpenses()
    {
        $expenses = Expense::orderByDesc('date')->orderByDesc('id')->get();

        return response()->json([
            'status' => 'success',
            'data' => $expenses,
        ]);
    }

    /**
     * Remove the specified expense from storage.
     */
    public function deleteExpense(int $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Expense deleted successfully.',
        ]);
    }
}
