<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $transactions = Transaction::with('user')->latest()->paginate(15);
        $totalRevenue = Transaction::where('status', 'success')->sum('amount');
        $successCount = Transaction::where('status', 'success')->count();

        return view('admin.transactions.index', compact('transactions', 'totalRevenue', 'successCount'));
    }
}

