<?php

namespace App\Http\Controllers;

use App\Account;
use App\Category;
use App\Wallet;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $transactions = \Auth::user()->transactions()->orderByDesc('id')->get();
        $categories = Category::where('user_id', '=', auth()->id())->get();
        $accounts = Account::where('user_id', '=', auth()->id())->get();
        $wallets = Wallet::where('user_id', '=', auth()->id())->get();

        return view('home', compact(['transactions', 'categories', 'accounts', 'wallets', 'pageTitle']));
    }
}
