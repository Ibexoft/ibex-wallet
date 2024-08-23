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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function create()
    // {
    //     $accountTypes = config('custom.account_types');
    //     $currencies = config('custom.currencies');

    //     return view('accounts.create', compact(['accountTypes', 'currencies']));
    // }

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
            'name'    => 'required',
            'type'     => 'required',
            'balance' => 'required',
            'currency' => 'required',
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
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Account $account
     *
     * @return \Illuminate\Http\Response
     */
    // public function edit(Account $account)
    // {
    //     $accountTypes = config('custom.account_types');
    //     $currencies = config('custom.currencies');

    //     return view('accounts.create', compact(['account', 'accountTypes', 'currencies']));
    // }

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
        // dd($request->all());
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name'      => 'required',
            'type'      => 'required',
            'balance'   => 'required',
            'currency'  => 'required',
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
        //
    }
}
