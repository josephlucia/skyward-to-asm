<?php

namespace App\Skyward\Courses;

use Excel;
use App\Course;

class Export
{
	public function run()
	{
		$filename = 'courses';
		
		$courses = Course::select('course_id', 'course_number', 'course_name', 'location_id')
						 ->get();

		$rows = $courses->toArray();

        Excel::create($filename, function ($excel) use ($rows) {
            $excel->sheet('', function ($sheet) use ($rows) {
                $sheet->fromArray($rows);
            });
        })->store('csv', storage_path('/exports'));
	}
}