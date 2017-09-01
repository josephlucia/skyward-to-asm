<?php

namespace App\Skyward\Staff;

use Excel;
use App\Staff;

class Export
{
	public function run()
	{
		$filename = 'staff';
		
		$staff = Staff::select('person_id', 'person_number', 'first_name', 'middle_name', 'last_name', 'email_address', 'sis_username', 'location_id')
					  ->get();

		$rows = $staff->toArray();

        Excel::create($filename, function ($excel) use ($rows) {
            $excel->sheet('', function ($sheet) use ($rows) {
                $sheet->fromArray($rows);
            });
        })->store('csv', storage_path('/exports'));
	}
}