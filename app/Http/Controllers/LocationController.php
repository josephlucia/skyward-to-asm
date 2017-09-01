<?php

namespace App\Http\Controllers;

use App\Skyward;
use App\Location;
use Illuminate\Http\Request;
use App\Skyward\Locations\Sync;
use App\Skyward\Locations\Export;

class LocationController extends Controller
{
    private $skyward;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Skyward $skyward)
    {
        $this->skyward = $skyward;
    }

    /**
     * Display the list of schools.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::all();

        return view('district.locations', compact('locations'));
    }

    /**
     * Fetch all locations and send to component.
     *
     * @return object
     */
    public function all()
    {
        $locations = Location::all();

        return $locations;
    }

    /**
     * Count the number of locations and send to component.
     *
     * @return object
     */
    public function count()
    {
        $locations = Location::where('sync', true)->count();

        return $locations;
    }

    /**
     * Update the location settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $location = Location::findOrFail($id);

        $location->update([
            'sync' => $request->sync
        ]);
    }

    /**
     * Store the locations in the database.
     *
     * @return void
     */
    public function store()
    {
        $sync = new Sync();

        $sync->run();
    }

    /**
     * Export the locations to CSV file.
     *
     * @return void
     */
    public function export()
    {
        $export = new Export();

        $export->run();
    }
}
