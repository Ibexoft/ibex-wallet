<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        $pageTitle = "Transactions";

        $paginatedTransactions = Auth::user()->transactions()->orderByDesc('transaction_date')->paginate(10);

        $transactions = $paginatedTransactions->getCollection()->groupBy(function ($transaction) {
            return Carbon::parse($transaction->transaction_date)->format('d M Y');
        });

        $categories = Category::where('user_id', '=', auth()->id())->get();
        $accounts = Account::where('user_id', '=', auth()->id())->get();
        $wallets = Wallet::where('user_id', '=', auth()->id())->get();

        return view('dashboard', compact(['paginatedTransactions', 'transactions', 'categories', 'accounts', 'wallets', 'pageTitle']));
    }
}
