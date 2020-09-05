<?php

namespace App\Http\Controllers;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('accounts')
            ->whereRaw("id=${id}")
            ->get()
            ;
    }
}
