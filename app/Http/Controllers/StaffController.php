<?php

namespace App\Http\Controllers;

use App\Staff;
use App\Skyward;
use App\Location;
use App\Skyward\Staff\Sync;
use Illuminate\Http\Request;
use App\Skyward\Staff\Export;

class StaffController extends Controller
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
     * Display the list of staff.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staff = Staff::orderBy('last_name', 'asc')->paginate(50);

        return view('district.staff', compact('staff'));
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
            0 => 'location_id',
            1 => 'person_id',
            2 => 'last_name',
            3 => 'first_name',
            4 => 'sis_username',
            5 => 'email_address'
        ];
        // Get all staff records.
        $staff = Staff::orderBy($columns[$request['order'][0]['column']], $request['order'][0]['dir'])
                      ->search($request['search']['value'])
                      ->offset($request['start'])
                      ->limit($request['length'])
                      ->get();
        // Prepare the data array.
        foreach($staff as $members) {
            $data[] = [
                $members->location_id,
                $members->person_id,
                $members->last_name,
                $members->first_name,
                $members->sis_username,
                $members->email_address
            ];
        }
        // Count total and filtered rows.
        $recordsTotal = Staff::all()->count();
        $recordsFiltered = Staff::search($request['search']['value'])->get()->count();
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
     * Count the number of staff and send to component.
     *
     * @return object
     */
    public function count()
    {
        $staff = Staff::count();

        return $staff;
    }

    /**
     * Store the staff in the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $sync = new Sync();

        $sync->run();
    }

    /**
     * Export the staff to CSV file.
     *
     * @return void
     */
    public function export()
    {
        $export = new Export();

        $export->run();
    }
}
