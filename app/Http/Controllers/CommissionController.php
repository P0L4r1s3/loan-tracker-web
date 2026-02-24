<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index(){
        $commissions = Commission::all();
        return view('admin.commissions.index',compact('commissions'));
    }

    public function create(){
        return view('admin.commissions.create');
    }

    public function store(Request $request){
        Commission::create($request->all());
        //return redirect()->route('commissions.index');

        return redirect()->back()->with('showCommissions', true);
    }

    public function edit(Commission $commission){
        return view('admin.commissions.edit',compact('commission'));
    }

    public function update(Request $request, Commission $commission){
        $commission->update($request->all());
        //return redirect()->route('commissions.index');
        return back();
    }

    public function destroy(Commission $commission){
        $commission->delete();
        return back();
    }
}
