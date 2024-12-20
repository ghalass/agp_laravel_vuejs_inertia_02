<?php

namespace App\Http\Controllers;

use App\Models\Parc;
use App\Models\Typeparc;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use function PHPUnit\Framework\isNumeric;

class ParcController extends Controller
{
    function index(Request $request)
    {
        $search = $request->search;
        $filter = $request->filter;
        $per_page = $request->per_page;

        $parcs = Parc::with('typeparc')
            ->when($search, function ($query) use ($search) {
                $query->where("name", "like", "%{$search}%");
            })
            ->when($filter, function ($query) use ($filter) {
                $query->where("typeparc_id", "like", $filter);
            })
            ->latest()
            ->paginate($per_page ?? 5);

        $typeparcs = Typeparc::all();

        return inertia('Parc/IndexParc', [
            'parcs'     => $parcs,
            'typeparcs' => $typeparcs,

            'filters'    => $request->all("search", "filter", "per_page"),
        ]);
    }

    function create()
    {
        $typeparcs = Typeparc::all();

        return inertia('Parc/CreateParc', [
            'typeparcs' => $typeparcs,
        ]);
    }

    function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'typeparc_id' => 'required'
        ], [], ['typeparc_id' => 'type de parc']);
        Parc::create([
            // ...$validatedData,
            'name' => $request->name,
            'typeparc_id' => $request->typeparc_id
        ]);
        return redirect()->back();
    }

    function edit(Parc $parc)
    {
        $typeparcs = Typeparc::all();
        return inertia('Parc/EditParc', [
            'typeparcs' => $typeparcs,
            'parc' => $parc,
        ]);
    }

    function update(Request $request, Parc $parc)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique((new Parc)->getTable(), "name")->ignore($parc->id)
            ],
            'typeparc_id' =>  [
                'required'
            ],
        ]);
        if ($request->name !== $parc->name || $request->typeparc_id !== $parc->typeparc_id) {
            $parc->name = $request->name;
            $parc->typeparc_id = $request->typeparc_id;
            $parc->save();
        }
        return redirect()->back();
    }

    function get_by_typeparc_id($id)
    {
        $parcs = Parc::where('typeparc_id', $id)->get();

        return response()->json(['parcs' => $parcs]);
    }

    function delete(Parc $parc)
    {
        if (count($parc->engins) > 0) {
            return redirect()->back()->withErrors([
                'message' => "Ce parc ne peut pas être supprimé car il existe des engins qui dépendent de ce dernier"
            ]);
        }

        $parc->delete();
        return redirect()->back();
    }
}
