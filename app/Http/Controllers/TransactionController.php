<?php

namespace App\Http\Controllers;

use App\Enums\TransactionType;
use App\Models\User;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'Dashboard';

        // Initial query
        $query = Auth::user()->transactions()->orderByDesc('transaction_date');

        // Apply filters if present
        if ($request->filled('categories')) {
            $query->withCategories($request->categories);
        }
        if ($request->filled('accounts')) {
            $query->withAccounts($request->accounts);
        }
        if ($request->filled('transaction_types')) {
            $query->withTransactionTypes($request->transaction_types);
        }
        if ($request->filled('min_amount') || $request->filled('max_amount')) {
            $query->withAmountRange($request->min_amount, $request->max_amount);
        }
        if ($request->filled('start_date') || $request->filled('end_date')) {
            $query->withDateRange($request->start_date, $request->end_date);
        }

        $paginatedTransactions = $query->paginate(10);

        $transactions = $paginatedTransactions->getCollection()->groupBy(function ($transaction) {
            return Carbon::parse($transaction->transaction_date)->format('d M Y');
        });

        $user = Auth::user();
        $total_balance = Transaction::total_balance($user->id);
        $available_balance = Transaction::available_balance($user->id);
        $income_this_month = Transaction::month_income($user->id);
        $expense_this_month = Transaction::month_expense($user->id);
        $owed = Transaction::owed($user->id);
        $other_owed = Transaction::other_owed($user->id);
        $categories = $user->categories()->where('parent_category_id', null)->get();
        $accounts = Account::where('user_id', '=', $user->id)->orderBy('name', 'asc')->get();
        $wallets = Wallet::where('user_id', '=', $user->id)->orderBy('name', 'asc')->get();

        return view(
            'transactions.index',
            compact(
                'transactions',
                'paginatedTransactions',
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
            ) + ['filters' => $request->all()]
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
        // Check if the authenticated user owns the transaction
        if ($transaction->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => '404 Not Found.'
            ], 404);
        }


        return response()->json([
            'success' => true,
            'data' => $transaction
        ]);
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
            'amount' => [
                'required',
                'numeric',
                'between:0,9999999.99'
            ],
            'transaction_date' => 'required|date',
            'type' => ['required', Rule::in(array_column(TransactionType::cases(), 'name'))],
            'src_account_id' => [
                'required',
                'exists:accounts,id'
            ],
            'dest_account_id' => [
                'nullable',
                'required_if:type,Transfer',
                'exists:accounts,id'
            ],
            'category_id' => [
                'nullable',
                'required_unless:type,Transfer',
                'exists:categories,id'
            ],
            'wallet_id' => [
                'nullable',
                'exists:wallets,id'
            ],
            'details' => [
                'nullable',
                'string',
                'min:3',
                'max:200'
            ],
        ], [
            'dest_account_id.required_if' => 'The destination account field is required.',
            'category_id.required_unless' => 'The category field is required.',
            'src_account_id.required' => 'The source account field is required.',
        ]);

        session([
            'transaction_date' => $request->transaction_date,
            'src_account_id' => $request->src_account_id,
            'category_id' => $request->category_id,
            'transaction_type' => $request->type,
        ]);

        $validated['user_id'] = auth()->id();
        Transaction::create($validated);

        return response()->json(['success' => true, 'message' => 'Transaction added successfully!']);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $validated = $request->validate([
            'amount' => [
                'required',
                'numeric',
                'between:0,9999999.99'
            ],
            'transaction_date' => 'required|date',
            'type' => ['required', Rule::in(array_column(TransactionType::cases(), 'name'))],
            'src_account_id' => [
                'required',
                'exists:accounts,id'
            ],
            'dest_account_id' => [
                'nullable',
                'required_if:type,Transfer',
                'exists:accounts,id'
            ],
            'category_id' => [
                'nullable',
                'required_unless:type,Transfer',
                'exists:categories,id'
            ],
            'wallet_id' => [
                'nullable',
                'exists:wallets,id'
            ],
            'details' => [
                'nullable',
                'string',
                'min:3',
                'max:200'
            ],
        ], [
            'dest_account_id.required_if' => 'The destination account field is required.',
            'category_id.required_unless' => 'The category field is required.',
            'src_account_id.required' => 'The source account field is required.',
        ]);

        $validated['user_id'] = auth()->id();
        $transaction->update($validated);

        return response()->json(['success' => true, 'message' => 'Transaction updated successfully!']);
    }


    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return response()->json(['success' => true, 'message' => 'Transaction deleted successfully!']);
    }
}
