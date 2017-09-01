<?php

namespace App\Http\Controllers;

use App\Roster;
use App\Skyward;
use App\Location;
use Illuminate\Http\Request;
use App\Skyward\Rosters\Sync;
use App\Skyward\Rosters\Export;

class RosterController extends Controller
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
     * Display the list of rosters.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('district.rosters');
    }

    /**
     * Build the data arrays for datatables plugin.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable(Request $request)
    {
        // Define the columns.
        $columns = [
            0 => 'roster_id',
            1 => 'class_id',
            2 => 'student_id'
        ];
        // Get all roster records.
        $rosters = Roster::orderBy($columns[$request['order'][0]['column']], $request['order'][0]['dir'])
                      ->search($request['search']['value'])
                      ->offset($request['start'])
                      ->limit($request['length'])
                      ->get();
        // Prepare the data array.
        foreach($rosters as $roster) {
            $data[] = [
                $roster->roster_id,
                $roster->class_id,
                $roster->student_id
            ];
        }
        // Count total and filtered rows.
        $recordsTotal = Roster::all()->count();
        $recordsFiltered = Roster::search($request['search']['value'])->get()->count();
        // Prepare the JSON file.
        $json = [
            'draw' => intval($request['draw']),
            'recordsTotal' => intval($recordsTotal),
            'recordsFiltered' => intval($recordsFiltered),
            'data' => $data
        ];

        return $json;
    }

    /**
     * Count the number of rosters and send to component.
     *
     * @return object
     */
    public function count()
    {
        $rosters = Roster::count();

        return $rosters;
    }

    /**
     * Store the roster sections in the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $sync = new Sync();

        $sync->run();
    }

    /**
     * Export the rosters to CSV file.
     *
     * @return void
     */
    public function export()
    {
        $export = new Export();

        $export->run();
    }
}
