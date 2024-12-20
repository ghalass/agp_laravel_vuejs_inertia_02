<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SaisieController extends Controller
{
    function index()
    {
        return inertia('Saisie/IndexSaisieRje');
    }
}
