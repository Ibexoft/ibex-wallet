<?php

namespace App\Http\Controllers;

use App\Enums\TransactionType;
use App\Models\Account;
use App\Models\Category;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Existing data
        $paginatedTransactions = Auth::user()->transactions()->orderByDesc('transaction_date')->paginate(10);

        $transactions = $paginatedTransactions->getCollection()->groupBy(function ($transaction) {
            return Carbon::parse($transaction->transaction_date)->format('d M Y');
        });

        $categories = Auth::user()->categories()->where('parent_category_id', null)->get();
        $accounts = Account::where('user_id', '=', auth()->id())->get();
        $wallets = Wallet::where('user_id', '=', auth()->id())->get();

        // Cards Data
        $totalIncome = Auth::user()->transactions()->where('type', 'income')->sum('amount');
        $totalExpense = Auth::user()->transactions()->where('type', 'expense')->sum('amount');

        // recent 5 (income/expenses) transactions
        $recentTransactions = Auth::user()->transactions()
            ->whereIn('type', [TransactionType::Income, TransactionType::Expense])
            ->orderByDesc('transaction_date')
            ->take(5)
            ->get();

        // Calculate income and expense for the last 6 months
        $monthlyData = collect([]);
        $currentDate = Carbon::now();

        $no_of_months = 6;
        for ($i = 0; $i < $no_of_months; $i++) {
            $startOfMonth = $currentDate->copy()->startOfMonth();
            $endOfMonth = $currentDate->copy()->endOfMonth();

            $income = Auth::user()->transactions()
                ->where('type', 'income')
                ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
                ->sum('amount');

            $expense = Auth::user()->transactions()
                ->where('type', 'expense')
                ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
                ->sum('amount');

            $monthlyData->push([
                'month' => $currentDate->format('M Y'),
                'income' => $income,
                'expense' => $expense,
            ]);

            $currentDate->subMonth(); // Move to the previous month
        }
        
        // Charts Data
        $chartData = [
            'labels' => $monthlyData->pluck('month')->reverse()->values(), // Months
            'income' => $monthlyData->pluck('income')->reverse()->values(), // Income
            'expense' => $monthlyData->pluck('expense')->reverse()->values(), // Expense
        ];


        // Categories Data
        // Fetch expense data for each category
        $categoriesData = DB::table('transactions')
        ->select('categories.name', DB::raw('SUM(transactions.amount) as total'))
        ->join('categories', 'transactions.category_id', '=', 'categories.id')
        ->where('transactions.type', 'expense')
        ->groupBy('categories.name')
        ->orderBy('total', 'desc')
        ->limit(5)
        ->get();

        // category progress bars data
        $totalExpenses = $categoriesData->sum('total');
        $categoriesProgress = $categoriesData->map(function ($category) use ($totalExpenses) {
            return [
                'name' => $category->name,
                'percentage' => round(($category->total / $totalExpenses) * 100, 2),
            ];
        });

        return view('dashboard', compact([
            'totalIncome', 'totalExpense', 'recentTransactions', 'chartData', 'categoriesProgress',
            'paginatedTransactions', 'transactions', 'categories', 
            'accounts', 'wallets', 'monthlyData'
        ]));
    }
}
