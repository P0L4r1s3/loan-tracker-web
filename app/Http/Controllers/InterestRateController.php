<?php

namespace App\Http\Controllers;

use App\Models\InterestRate;
use Illuminate\Http\Request;

class InterestRateController extends Controller
{
    public function index() {
        $rates = InterestRate::all();
        return view('admin.interest_rates.index', compact('rates'));
    }

    public function create() {
        return view('admin.interest_rates.create');
    }

    public function store(Request $request) {
        InterestRate::create($request->all());
        return redirect()->back()->with('showRates', true);
        //return redirect()->route('admin.dashboard'); //redireciona a la vista despues de registrar una tasa nueva
    }

    public function edit(InterestRate $interest_rate) {
        return view('admin.interest_rates.edit', compact('interest_rate'));
    }

    public function update(Request $request, InterestRate $interest_rate) {
        $interest_rate->update($request->all());
        //return redirect()->route('interest-rates.index');
        return back();
    }

    public function destroy(InterestRate $interest_rate) {
        $interest_rate->delete();
        return back();
    }
}

