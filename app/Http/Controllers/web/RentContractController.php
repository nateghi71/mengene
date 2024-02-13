<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;

class RentContractController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $provinces = Province::all();
        return view('rent_contract.create' , compact('provinces'));
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
