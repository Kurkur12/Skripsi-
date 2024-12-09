<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\Maintenance;
use App\Models\Location;
use App\Models\Item;

class HomeController extends Controller
{
    public function home()
    {
        $recordCount = Record::count();
        $maintenanceCount = Maintenance::count();
        $locationCount = Location::count();
        $locations = Location::all();

        return view('home', compact('recordCount', 'maintenanceCount', 'locationCount', 'locations'));
    }

    public function getRecords()
    {
        $records = Record::all();
        return response()->json($records);
    }

    public function getMaintenance()
    {
        $maintenance = Maintenance::all();
        return response()->json($maintenance);
    }

    public function getLocations()
    {
        $locations = Location::all();
        return response()->json($locations);
    }

    public function viewLocation($id)
{
    $location = Location::findOrFail($id);
    $items = $location->items;
    return view('location.view', compact('location', 'items'));
}
}