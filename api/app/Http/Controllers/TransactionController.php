<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('transactions')
            ->whereRaw("`from`=${id} OR `to`=${id}")
            ->get()
            ;
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
        $to      = $request->input('to');
        $amount  = $request->input('amount');
        $details = $request->input('details');

        $account = DB::table('accounts')
            ->whereRaw("id=${id}")
            ->update(['balance' => DB::raw('balance-'.$amount)])
        ;

        $account = DB::table('accounts')
            ->whereRaw("id=${to}")
            ->update(['balance' => DB::raw('balance+'.$amount)])
        ;

        DB::table('transactions')->insert(
            [
                'from'    => $id,
                'to'      => $to,
                'amount'  => $amount,
                'details' => $details,
            ]
        );
    }
}
