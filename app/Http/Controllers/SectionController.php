<?php

namespace App\Http\Controllers;

use App\Section;
use App\Skyward;
use App\Location;
use Illuminate\Http\Request;
use App\Skyward\Sections\Sync;
use App\Skyward\Sections\Export;

class SectionController extends Controller
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
     * Display the list of section sections.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('district.sections');
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
            2 => 'class_id',
            3 => 'class_number',
            4 => 'instructor_id',
            5 => 'instructor_id_2',
            6 => 'instructor_id_3'
        ];
        // Get all section records.
        $sections = Section::orderBy($columns[$request['order'][0]['column']], $request['order'][0]['dir'])
                      ->search($request['search']['value'])
                      ->offset($request['start'])
                      ->limit($request['length'])
                      ->get();
        // Prepare the data array.
        foreach($sections as $section) {
            $data[] = [
                $section->location_id,
                $section->course_id,
                $section->class_id,
                $section->class_number,
                $section->instructor_id,
                $section->instructor_id_2,
                $section->instructor_id_3
            ];
        }
        // Count total and filtered rows.
        $recordsTotal = Section::all()->count();
        $recordsFiltered = Section::search($request['search']['value'])->get()->count();
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
     * Count the number of sections and send to component.
     *
     * @return object
     */
    public function count()
    {
        $sections = Section::count();

        return $sections;
    }

    /**
     * Store the section sections in the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $sync = new Sync();

        $sync->run();
    }

    /**
     * Export the sections to CSV file.
     *
     * @return void
     */
    public function export()
    {
        $export = new Export();

        $export->run();
    }
}
