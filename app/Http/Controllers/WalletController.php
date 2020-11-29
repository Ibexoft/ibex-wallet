<?php

namespace App\Http\Controllers;

use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
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
        $page_title = 'Wallets';
        $wallets = \Auth::user()->wallets()->get();

        return view(
            'wallets.index',
            compact('wallets', 'page_title')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('wallets.create');
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
        Wallet::create([
            'user_id'               => auth()->id(),
            'name'                  => $request->name,
            'icon'                  => $request->icon,
        ]);

        return redirect('wallets');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Wallet $wallet
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Wallet $wallet)
    {
        $page_title = 'Wallet';

        return view('wallets.show', compact('wallet', 'page_title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Wallet $wallet
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Wallet $wallet)
    {
        return view('wallets.create', compact(['wallet']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Wallet              $wallet
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wallet $wallet)
    {
        Wallet::where('user_id', Auth::id())
            ->where('id', $wallet->id)
            ->update([
                'name'  => $request->name,
                'icon'  => $request->icon
            ]);

        return redirect('wallets');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Wallet $wallet
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallet $wallet)
    {
        //
    }
}
