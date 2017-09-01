<?php

namespace App\Http\Controllers;

use App\Skyward;
use App\Student;
use App\Location;
use Illuminate\Http\Request;
use App\Skyward\Students\Sync;
use App\Skyward\Students\Export;

class StudentController extends Controller
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
     * Display the list of students.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();

        return view('district.students', compact('students'));
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
        $students = Student::orderBy($columns[$request['order'][0]['column']], $request['order'][0]['dir'])
                      ->search($request['search']['value'])
                      ->offset($request['start'])
                      ->limit($request['length'])
                      ->get();
        // Prepare the data array.
        foreach($students as $student) {
            $data[] = [
                $student->location_id,
                $student->person_id,
                $student->last_name,
                $student->first_name,
                $student->grade_level,
                $student->sis_username,
                $student->email_address
            ];
        }
        // Count total and filtered rows.
        $recordsTotal = Student::all()->count();
        $recordsFiltered = Student::search($request['search']['value'])->get()->count();
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
     * Count the number of students and send to component.
     *
     * @return object
     */
    public function count()
    {
        $students = Student::count();

        return $students;
    }

    /**
     * Store the students in the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $sync = new Sync();

        $sync->run();
    }

    /**
     * Export the students to CSV file.
     *
     * @return void
     */
    public function export()
    {
        $export = new Export();

        $export->run();
    }
}
