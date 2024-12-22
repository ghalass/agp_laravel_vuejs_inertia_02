<?php

namespace App\Http\Controllers;

use App\Models\Engin;
use App\Models\Parc;
use App\Models\Site;
use App\Models\Typeparc;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EnginController extends Controller
{
    function index()
    {
        $engins = Engin::with('parc')
            ->with('site')
            ->latest()
            ->paginate(5);
        $typeparcs = Typeparc::all();
        $sites = Site::all();
        return inertia('Engin/IndexEngin', [
            'engins'    => $engins,
            'typeparcs' => $typeparcs,
            'sites'     => $sites,
        ]);
    }

    function store(Request $request)
    {
        $request->validate(
            [
                'name'          => 'required',
                'parc_id'       => 'required',
                'site_id'       => 'required',
            ],
            [],
            [
                'name'          => "nom de l'engin",
                'parc_id'       => 'parc',
                'site_id'       => 'nom du site',
            ]
        );

        Engin::create([
            'name'      => $request->name,
            'parc_id'   => $request->parc_id,
            'site_id'   => $request->site_id,
        ]);

        return redirect()->back();
    }

    function edit(Engin $engin)
    {
        $engin = Engin::with('parc')->where('id', $engin->id)->first();
        return response()->json(['engin' => $engin]);
    }

    function update(Request $request, Engin $engin)
    {
        $request->validate(
            [
                'name'          => [
                    'required',
                    Rule::unique((new Engin)->getTable(), "name")->ignore($engin->id)
                ],
                'parc_id'       => 'required',
                'site_id'       => 'required',
            ],
            [],
            [
                'name'          => "nom de l'engin",
                'parc_id'       => 'parc',
                'site_id'       => 'nom du site',
            ]
        );
        if ($request->name !== $engin->name || $request->parc_id !== $engin->parc_id || $request->site_id !== $engin->site_id) {

            $engin->name    = $request->name;
            $engin->parc_id = $request->parc_id;
            $engin->site_id = $request->site_id;
            $engin->save();
        }
        return redirect()->back();
    }

    function delete(Engin $engin)
    {
        $engin->delete();
        return redirect()->back();
    }

    function get_by_parc_id($id)
    {
        $engins = Engin::where('parc_id', $id)->get();

        return response()->json(['engins' => $engins]);
    }
}