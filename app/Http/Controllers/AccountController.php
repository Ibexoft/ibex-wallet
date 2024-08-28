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
    public function index()
    {
        $accounts = Account::where('user_id', '=', auth()->id())->get();

        $accountTypes = config('custom.account_types');
        $currencies = config('custom.currencies');

        return view('accounts.index', get_defined_vars());
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
            'name'      => 'required|string|max:35',
            'type'      => 'required|in:' . implode(',', array_keys(config('custom.account_types'))),
            'balance'   => 'required|numeric|min:0',
            'currency'  => 'required|in:' . implode(',', array_keys(config('custom.currencies'))),
        ]);

        Account::create([
            'user_id'   => Auth::id(),
            'name'      => $request->name,
            'type'      => $request->type,
            'icon'      => $request->icon,
            'balance'   => $request->balance,
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
        //
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
            'name'      => 'required|string|max:35',
            'type'      => 'required|in:' . implode(',', array_keys(config('custom.account_types'))),
            'balance'   => 'required|numeric|min:0',
            'currency'  => 'required|in:' . implode(',', array_keys(config('custom.currencies'))),
        ]);

        // Find the account by ID
        $account = Account::findOrFail($id);

        // Update the account with the validated data
        $account->update([
            'name'      => $request->name,
            'type'      => $request->type,
            'balance'   => $request->balance,
            'currency'  => $request->currency,
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
            $account->delete();

            return response()->json([
                'success' => true,
                'message' => 'Account deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the account.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
