<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
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
        $accounts = Account::all();

        return view('accounts.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accountTypes = config('custom.account_types');
        $currencies = config('custom.currencies');

        return view('accounts.add', compact(['accountTypes', 'currencies']));
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
            'title'    => 'required',
            'type'     => 'required',
            'currency' => 'required',
        ]);

        Account::create([
            'user_id'  => Auth::id(),
            'title'    => $request->title,
            'type'     => $request->type,
            'currency' => $request->currency,
        ]);

        return redirect('accounts');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Account $account
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
     * @param \App\Account $account
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        $accountTypes = config('custom.account_types');
        $currencies = config('custom.currencies');

        return view('accounts.edit', compact(['account', 'accountTypes', 'currencies']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Account             $account
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'title'    => 'required',
            'type'     => 'required',
            'currency' => 'required',
        ]);

        Account::where('user_id', Auth::id())
        ->where('id', $request->id)
        ->update([
            'title'    => $request->title,
            'type'     => $request->type,
            'currency' => $request->currency,
        ]);

        return redirect('accounts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Account $account
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        //
    }
}
