<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::withCount('items')->get();
        return response()->json($locations);
    }

    public function show($id)
    {
        $location = Location::with('items')->findOrFail($id);
        return response()->json($location);
    }

    // Add other methods (store, update, destroy) as needed
}