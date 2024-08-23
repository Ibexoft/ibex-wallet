<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $pageTitle = 'Dashboard';
        $transactions = Auth::user()->transactions()->orderByDesc('id')->get();

        $user = Auth::user();

        $total_balance = Transaction::total_balance($user->id);
        $available_balance = Transaction::available_balance($user->id);
        $income_this_month = Transaction::month_income($user->id);
        $expense_this_month = Transaction::month_expense($user->id);
        $owed = Transaction::owed($user->id);
        $other_owed = Transaction::other_owed($user->id);
        $categories = Category::where('user_id', '=', auth()->id())->get();
        $accounts = Account::where('user_id', '=', auth()->id())->get();
        $wallets = Wallet::where('user_id', '=', auth()->id())->get();
        // dd($transactions, $categories, $accounts, $wallets);

        return view(
            'transactions.index',
            compact(
                'transactions',
                'pageTitle',
                'total_balance',
                'available_balance',
                'income_this_month',
                'expense_this_month',
                'owed',
                'other_owed',
                'categories',
                'accounts',
                'wallets'
            )
        );
    }

    public function create()
    {
        $categories = Category::where('user_id', '=', auth()->id())->where('parent_category_id', null)->get();
        $accounts = Account::where('user_id', '=', auth()->id())->get();
        $wallets = Wallet::where('user_id', '=', auth()->id())->get();

        return view('transactions.create', compact(['categories', 'accounts', 'wallets']));
    }


    public function show(Transaction $transaction)
    {
        $pageTitle = 'Transaction Details';

        return view('transactions.show', compact('transaction', 'pageTitle'));
    }

    public function edit(Transaction $transaction)
    {
        $pageTitle = 'Edit Transaction';

        $categories = Category::where('user_id', '=', auth()->id())->get();
        $accounts = Account::where('user_id', '=', auth()->id())->get();
        $wallets = Wallet::where('user_id', '=', auth()->id())->get();
        // $tags = Tag::where('user_id', '=', auth()->id())->get();

        return view('transactions.edit', compact(['transaction', 'categories', 'accounts', 'wallets', 'pageTitle']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'transaction_date' => 'required|date',
            'type' => 'required|in:1,2,3',
            'src_account_id' => 'required_if:type,!=,3|exists:accounts,id',
            'dest_account_id' => [
                'nullable', 
                'required_if:type,3', 
                'exists:accounts,id'
            ],
            'category_id' => [
                'nullable', 
                'required_if:type,!=,3', 
                'exists:categories,id'
            ],
            'wallet_id' => 'nullable|exists:wallets,id',
            'details' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        Transaction::create($validated);

        return response()->json(['success' => true, 'message' => 'Transaction added successfully!']);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'transaction_date' => 'required|date',
            'type' => 'required|in:1,2,3',
            'src_account_id' => 'required_if:type,!=,3|exists:accounts,id',
            'dest_account_id' => [
                'nullable', 
                'required_if:type,3', 
                'exists:accounts,id'
            ],
            'category_id' => [
                'nullable', 
                'required_if:type,!=,3', 
                'exists:categories,id'
            ],
            'wallet_id' => 'nullable|exists:wallets,id',
            'details' => 'nullable|string',
        ]);

        $transaction->update($validated);

        return response()->json(['success' => true, 'message' => 'Transaction updated successfully!']);
    }


    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return response()->json(['success' => true,'message' => 'Transaction deleted successfully!']);
    }
}
