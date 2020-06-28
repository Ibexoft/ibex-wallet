<?php

namespace App\Http\Controllers;

use App\Account;
use App\Transaction;
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
        $page_title = 'Dashboard';
        $transactions = Transaction::latest()->get();

        $user = \Auth::user();

        $total_balance = Transaction::total_balance($user->id);
        $available_balance = Transaction::available_balance($user->id);
        $income_this_month = Transaction::month_income($user->id);
        $expense_this_month = Transaction::month_expense($user->id);
        $owed = Transaction::owed($user->id);
        $other_owed = Transaction::other_owed($user->id);

        return view(
            'transactions.index',
            compact('transactions', 'page_title', 'total_balance', 'available_balance', 'income_this_month', 'expense_this_month', 'owed', 'other_owed')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = 'Add Transaction';

        $accounts = Account::where('user_id', '=', auth()->id())->get();
        // $tags = Tag::where('user_id', '=', auth()->id())->get();
        return view('transactions.create', compact(['accounts', 'page_title']));
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
            'user_id'         => auth()->id(),
            'amount'          => $request->amount,
            'description'     => $request->description,
            'type'            => $request->type,
            'from_account_id' => $request->from_account,
            'to_account_id'   => $request->to_account,
            'for_whom'        => $request->for_whom,
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
        $page_title = 'Transaction Details';

        return view('transactions.show', compact('transaction', 'page_title'));
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
        //
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
        //
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
