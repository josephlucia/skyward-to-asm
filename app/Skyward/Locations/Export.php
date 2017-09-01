<?php

namespace App\Skyward\Locations;

use Excel;
use App\Location;

class Export
{
	public function run()
	{
		$filename = 'locations';
		$locations = Location::where('sync', true)
							 ->select('location_id', 'location_name')
							 ->orderBy('location_id')
							 ->get();

		$rows = $locations->toArray();

        Excel::create($filename, function ($excel) use ($rows) {
            $excel->sheet('', function ($sheet) use ($rows) {
                $sheet->fromArray($rows);
            });
        })->store('csv', storage_path('/exports'));
	}
}