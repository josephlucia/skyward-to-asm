<?php

namespace App\Http\Controllers;

use App\Course;
use App\Skyward;
use App\Location;
use Illuminate\Http\Request;
use App\Skyward\Courses\Sync;
use App\Skyward\Courses\Export;

class CourseController extends Controller
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
     * Display the list of courses.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('district.courses');
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
            1 => 'course_id',
            2 => 'course_number',
            3 => 'course_name'
        ];
        // Get all course records.
        $courses = Course::orderBy($columns[$request['order'][0]['column']], $request['order'][0]['dir'])
                      ->search($request['search']['value'])
                      ->offset($request['start'])
                      ->limit($request['length'])
                      ->get();
        // Prepare the data array.
        foreach($courses as $course) {
            $data[] = [
                $course->location_id,
                $course->course_id,
                $course->course_number,
                $course->course_name
            ];
        }
        // Count total and filtered rows.
        $recordsTotal = Course::all()->count();
        $recordsFiltered = Course::search($request['search']['value'])->get()->count();
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
     * Count the number of courses and send to component.
     *
     * @return object
     */
    public function count()
    {
        $courses = Course::count();

        return $courses;
    }

    /**
     * Store the courses in the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $sync = new Sync();

        $sync->run();
    }

    /**
     * Export the courses to CSV file.
     *
     * @return void
     */
    public function export()
    {
        $export = new Export();

        $export->run();
    }
}
