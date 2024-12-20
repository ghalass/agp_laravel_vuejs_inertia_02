<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SiteController extends Controller
{
    function index()
    {
        $sites = Site::latest()->paginate(2);
        return inertia('Site/IndexSite', ['sites' => $sites]);
    }
    function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:App\Models\site,name'
        ]);
        Site::create(['name' => $request->name]);
        return redirect()->back();
    }
    function edit(Site $site)
    {
        return response()->json(['site' => $site]);
    }
    function update(Request $request, Site $site)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique((new Site)->getTable(), "name")->ignore($site->id)
            ]
        ]);
        if ($request->name !== $site->name) {
            $site->name = $request->name;
            $site->save();
        }
        return redirect()->back();
    }
    function delete(Site $site)
    {
        if (count($site->engins) > 0) {
            return redirect()->back()->withErrors([
                'message' => "Ce site ne peut pas être supprimé car il existe des engins qui dépendent de ce dernier"
            ]);
        }
        $site->delete();
        return redirect()->back();
    }
}
