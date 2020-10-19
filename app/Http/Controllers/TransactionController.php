<?php

namespace App\Http\Controllers;

use App\User;
use App\Account;
use App\Category;
use App\Transaction;
use App\Wallet;
use Illuminate\Http\Request;

class TransactionController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Dashboard';
        $transactions = \Auth::user()->transactions()->get();

        $user = \Auth::user();

        $total_balance = Transaction::total_balance($user->id);
        $available_balance = Transaction::available_balance($user->id);
        $income_this_month = Transaction::month_income($user->id);
        $expense_this_month = Transaction::month_expense($user->id);
        $owed = Transaction::owed($user->id);
        $other_owed = Transaction::other_owed($user->id);

        return view(
            'transactions.index',
            compact('transactions', 'pageTitle', 'total_balance', 'available_balance', 'income_this_month', 'expense_this_month', 'owed', 'other_owed')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = 'Add Transaction';

        // $categories = Category::latest()->get();
        $categories = Category::where('user_id', '=', auth()->id())->get();
        $accounts = Account::where('user_id', '=', auth()->id())->get();
        $wallets = Wallet::where('user_id', '=', auth()->id())->get();
        // $tags = Tag::where('user_id', '=', auth()->id())->get();

        return view('transactions.create', compact(['categories', 'accounts', 'wallets', 'pageTitle']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validatedData = $request->validate([
        //     'amount' => $request->amount,
        //     'description' => $request->description,
        //     'type' => $request->type,
        //     'from_account_id' => $request->from_account_id,
        //     'to_account_id' => $request->to_account_id,
        //     'for_whom' => $request->for_whom
        // ]);

        Transaction::create([
            'user_id'           => auth()->id(),
            'type'              => $request->type,
            'amount'            => $request->amount,
            'category_id'       => $request->category_id,
            'src_account_id'    => $request->src_account_id,
            'dest_account_id'   => $request->dest_account_id,
            'details'           => $request->details,
            'spent_on'          => $request->spent_on,
            'wallet_id'         => $request->wallet_id,
        ]);

        return redirect('transactions');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Transaction $transaction
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        $pageTitle = 'Transaction Details';

        return view('transactions.show', compact('transaction', 'pageTitle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Transaction $transaction
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        $pageTitle = 'Edit Transaction';

        // $categories = Category::latest()->get();
        $categories = Category::where('user_id', '=', auth()->id())->get();
        $accounts = Account::where('user_id', '=', auth()->id())->get();
        $wallets = Wallet::where('user_id', '=', auth()->id())->get();
        // $tags = Tag::where('user_id', '=', auth()->id())->get();

        return view('transactions.edit', compact(['transaction', 'categories', 'accounts', 'wallets', 'pageTitle']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Transaction         $transaction
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $transaction->type = $request->type;
        $transaction->amount = $request->amount;
        $transaction->category_id = $request->category_id;
        $transaction->src_account_id = $request->src_account_id;
        $transaction->dest_account_id = $request->dest_account_id;
        $transaction->details = $request->details;
        $transaction->spent_on = $request->spent_on;
        $transaction->wallet_id = $request->wallet_id;

        $transaction->save();

        return redirect('transactions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Transaction $transaction
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
