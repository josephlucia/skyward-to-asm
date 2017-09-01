<?php

namespace App\Skyward\Sections;

use Excel;
use App\Section;

class Export
{
	public function run()
	{
		$filename = 'classes';
		
		$sections = Section::select('class_id', 'class_number', 'course_id', 'instructor_id', 'instructor_id_2', 'instructor_id_3', 'location_id')
						   ->get();

		$rows = $sections->toArray();

        Excel::create($filename, function ($excel) use ($rows) {
            $excel->sheet('', function ($sheet) use ($rows) {
                $sheet->fromArray($rows);
            });
        })->store('csv', storage_path('/exports'));
	}
}