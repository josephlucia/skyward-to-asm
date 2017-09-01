<?php

namespace App\Skyward\Rosters;

use Excel;
use App\Roster;
use App\Student;

class Export
{
	public function run()
	{
		$filename = 'rosters';
		
		$rosters = Roster::select('roster_id', 'class_id', 'student_id')
						 ->get();

		$rows = $this->cleanup($rosters->toArray());

        Excel::create($filename, function ($excel) use ($rows) {
            $excel->sheet('', function ($sheet) use ($rows) {
                $sheet->fromArray($rows);
            });
        })->store('csv', storage_path('/exports'));
	}

	private function cleanup($rosters)
	{
		$students = Student::get()->pluck('person_id')->toArray();

		$filtered = [];

		foreach($rosters as $roster) {
			if(in_array($roster['student_id'], $students)) {
				$filtered[] = $roster;
			}
		}
		
		return $filtered;
	}
}