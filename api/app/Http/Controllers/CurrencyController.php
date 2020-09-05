<?php

namespace App\Http\Controllers;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('currencies')
            ->get()
            ;
    }
}
