<?php

namespace App\Skyward\Students;

use Excel;
use App\Student;

class Export
{
	public function run()
	{
		$filename = 'students';
		
		$students = Student::select('person_id', 'person_number', 'first_name', 'middle_name', 'last_name', 'grade_level', 'email_address', 'sis_username', 'password_policy', 'location_id')
					  	   ->get();

		$rows = $students->toArray();

        Excel::create($filename, function ($excel) use ($rows) {
            $excel->sheet('', function ($sheet) use ($rows) {
                $sheet->fromArray($rows);
            });
        })->store('csv', storage_path('/exports'));
	}
}