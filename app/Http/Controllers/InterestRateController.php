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

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'rate' => 'required|numeric|min:0'
    ]);

    InterestRate::create([
        'name' => $request->name,
        'rate' => $request->rate
    ]);
        return redirect()->back()->with('showRates', 'Tasa creada correctamente');
    }

    public function edit(InterestRate $interest_rate) {
        return view('admin.interest_rates.edit', compact('interest_rate'));
    }

    public function update(Request $request, InterestRate $interest_rate)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $interest_rate->update([
        'name' => $request->name
    ]);

    return back()->with('success','Nombre actualizado');
}

    public function destroy(InterestRate $interest_rate) {
        $interest_rate->delete();
        return back();
    }
}

