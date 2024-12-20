<?php

namespace App\Http\Controllers;

use App\Models\Typeparc;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TypeparcController extends Controller
{
    function index()
    {
        $typeparcs = Typeparc::latest()->paginate(2);
        return inertia('Typeparc/IndexTypeparc', ['typeparcs' => $typeparcs]);
    }
    function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:App\Models\Typeparc,name'
        ]);
        Typeparc::create(['name' => $request->name]);
        return redirect()->back();
    }
    function edit(Typeparc $typeparc)
    {
        return response()->json(['typeparc' => $typeparc]);
    }
    function update(Request $request, Typeparc $typeparc)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique((new Typeparc)->getTable(), "name")->ignore($typeparc->id)
            ]
        ]);
        if ($request->name !== $typeparc->name) {
            $typeparc->name = $request->name;
            $typeparc->save();
        }
        return redirect()->back();
    }
    function delete(Typeparc $typeparc)
    {
        if (count($typeparc->parcs) > 0) {
            return redirect()->back()->withErrors([
                'message' => "Ce typeparc ne peut pas être supprimé car il existe des parcs qui dépendent de ce dernier"
            ]);
        }
        $typeparc->delete();
        return redirect()->back();
    }
}
