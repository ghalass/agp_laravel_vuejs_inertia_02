<?php

namespace App\Http\Controllers;

use App\Models\Saisierje;
use App\Models\Site;
use App\Models\Typepanne;
use App\Models\Typeparc;
use Illuminate\Http\Request;

class SaisieController extends Controller
{
    function index(Request $request)
    {
        $saisie_rjes = Saisierje::whereDate('daterje', '=', date($request->daterje))
            ->where('engin_id', '=', $request->engin_id)
            ->with('engin')
            ->with('site')
            ->with('panne')
            ->get();

        // return response()->json([
        //     'saisie_rjes' => $saisie_rjes,
        //     // 'daterje' => $request->daterje,
        //     // 'engin_id' => $request->engin_id,
        // ]);


        return inertia('Saisie/IndexSaisieRje', [
            'sites'             => Site::all(),
            'typeparcs'         => Typeparc::all(),
            'typepannes'        => Typepanne::all(),
            'saisie_rjes'       => $saisie_rjes,
            'filters'           => $request->all("daterje", "engin_id"),
        ]);
    }

    // function get_by_date_engin(Request $request)
    // {
    //     $saisie_rjes = Saisierje::whereDate('daterje', '=', date($request->daterje))
    //         ->where('engin_id', '=', $request->engin_id)
    //         ->with('engin')
    //         ->with('site')
    //         ->with('panne')
    //         ->get();

    //     // return response()->json([
    //     //     'saisie_rjes' => $saisie_rjes,
    //     //     // 'daterje' => $request->daterje,
    //     //     // 'engin_id' => $request->engin_id,
    //     // ]);

    //     return inertia('Parc/IndexParc', [
    //         'saisie_rjes'     => $saisie_rjes,
    //     ]);
    // }
}