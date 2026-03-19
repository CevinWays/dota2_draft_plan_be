<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hero;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    public function index(Request $request)
    {
        $query = Hero::query();

        if ($request->has('localized_name')) {
            $query->where('localized_name', 'ilike', '%' . $request->localized_name . '%');
        }

        if ($request->has('primary_attr')) {
            $query->where('primary_attr', $request->primary_attr);
        }

        $heroes = $query->get();

        return response()->json([
            'data' => $heroes
        ]);
    }

    public function show(Hero $hero)
    {
        return response()->json([
            'data' => $hero
        ]);
    }
}
