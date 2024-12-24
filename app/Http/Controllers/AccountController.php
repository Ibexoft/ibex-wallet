<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Account::where('user_id', auth()->id());
    
        // Search by account name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
    
        // Sorting functionality
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'balance_asc':
                    $query->orderBy('balance', 'asc');
                    break;
                case 'balance_desc':
                    $query->orderBy('balance', 'desc');
                    break;
            }
        }
    
        $accounts = $query->get();
        $accountTypes = config('custom.account_types');
        $currencies = config('custom.currencies');
    
        return view('accounts.index', compact('accounts', 'accountTypes', 'currencies'));
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:35|unique:accounts,name',
            'type' => 'required|in:' . implode(',', array_keys(config('custom.account_types'))),
            'balance' => 'required|numeric|min:0',
            'currency' => 'required|in:' . implode(',', array_keys(config('custom.currencies'))),
        ]);

        $validatedData['user_id'] = auth()->id();

        Account::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'type' => $request->type,
            'icon' => $request->icon,
            'balance' => $request->balance,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Account created successfully.'
        ]);
    }



    /**
     * Display the specified resource.
     *
     * @param \App\Models\Account $account
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        // Check if the authenticated user owns the account
        if ($account->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => '404 Not Found.'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $account
        ]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Account             $account
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:35|unique:accounts,name,' . $id,
            'type' => 'required|in:' . implode(',', array_keys(config('custom.account_types'))),
            'balance' => 'required|numeric|min:0',
            'currency' => 'required|in:' . implode(',', array_keys(config('custom.currencies'))),
        ]);

        $validatedData['user_id'] = auth()->id();

        // Find the account by ID
        $account = Account::findOrFail($id);

        // Update the account with the validated data
        $account->update([
            'name' => $request->name,
            'type' => $request->type,
            'balance' => $request->balance,
            'currency' => $request->currency,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Account updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Account $account
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        try {
            $hasTransactions = \DB::table('transactions')
                ->where('src_account_id', $account->id)
                ->orWhere('dest_account_id', $account->id)
                ->exists();  
                
            if ($hasTransactions) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete an account associated with a transaction'
                ]);
            }
            
            $account->delete();
            return response()->json([
                'success' => true,
                'message' => 'Account deleted successfully.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the account.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
