<?php

namespace App\Http\Controllers;

use App\Enums\TransactionType;
use App\Models\Account;
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
        $user = Auth::user();
        $no_of_months = 6;

        // Fetch categories, accounts
        $categories = $user->categories()->whereNull('parent_category_id')->get();
        $accounts = Account::where('user_id', $user->id)->get();

        // Fetch total income and expense for the tenure given
        $totalIncome = $user->getTotalIncome($no_of_months);
        $totalExpense = $user->getTotalExpense($no_of_months);
        
        // Fetch recent transactions (last 5 income/expenses)
        $recentTransactions = $user->transactions()
            ->whereIn('type', [TransactionType::Income, TransactionType::Expense])
            ->latest('transaction_date')
            ->take(5)
            ->get();

        // Fetch income and expense data for the last 6 months
        $monthlyData = $user->getMonthlyIncomeExpense($no_of_months);
        
        // Prepare chart data
        $chartData = [
            'labels' => $monthlyData->pluck('month')->reverse()->values(),
            'income' => $monthlyData->pluck('income')->reverse()->values(),
            'expense' => $monthlyData->pluck('expense')->reverse()->values(),
        ];

        // Fetch top 5 expense categories
        $categoriesData = DB::table('transactions')
            ->select('categories.name', DB::raw('SUM(transactions.amount) as total'))
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.type', 'expense')
            ->where('transactions.user_id', $user->id)
            ->groupBy('categories.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Calculate category progress bars
        $totalExpenses = $categoriesData->sum('total') ?: 1; // Avoid division by zero
        $categoriesProgress = $categoriesData->map(fn($category) => [
            'name' => $category->name,
            'percentage' => round(($category->total / $totalExpenses) * 100, 2),
        ]);

        return view('dashboard', compact(
            'totalIncome', 'totalExpense', 'recentTransactions', 'chartData', 'categoriesProgress', 'categories', 'accounts', 'monthlyData'
        ));
    }

}
