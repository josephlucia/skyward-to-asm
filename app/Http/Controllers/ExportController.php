<?php

namespace App\Http\Controllers;

use App\Credential;

use App\Skyward\Staff\Sync as StaffSync;
use App\Skyward\Rosters\Sync as RostersSync;
use App\Skyward\Courses\Sync as CoursesSync;
use App\Skyward\Sections\Sync as SectionsSync;
use App\Skyward\Students\Sync as StudentsSync;
use App\Skyward\Locations\Sync as LocationsSync;

use App\Skyward\Staff\Export as StaffExport;
use App\Skyward\Rosters\Export as RostersExport;
use App\Skyward\Courses\Export as CoursesExport;
use App\Skyward\Sections\Export as SectionsExport;
use App\Skyward\Students\Export as StudentsExport;
use App\Skyward\Locations\Export as LocationsExport;

class ExportController extends Controller
{
    /**
     * Run the nightly export.
     *
     * @return void
     */
    public function run()
    {
    	$credentials = Credential::find(1);

    	if($credentials->sync == true) {
	    	// Locations
	    	$locationsSync = new LocationsSync();
	    	if($locationsSync->run()) {
	    		$locationsExport = new LocationsExport();
	    		$locationsExport->run();
	    	}
	    	// Staff
	    	$staffSync = new StaffSync();
	    	if($staffSync->run()) {
	    		$staffExport = new StaffExport();
	    		$staffExport->run();
	    	}
	    	// Students
	    	$studentsSync = new StudentsSync();
	    	if($studentsSync->run()) {
	    		$studentsExport = new StudentsExport();
	    		$studentsExport->run();
	    	}
	    	// Courses
	    	$coursesSync = new CoursesSync();
	    	if($coursesSync->run()) {
	    		$coursesExport = new CoursesExport();
	    		$coursesExport->run();
	    	}
	    	// Sections
	    	$sectionsSync = new SectionsSync();
	    	if($sectionsSync->run()) {
	    		$sectionsExport = new SectionsExport();
	    		$sectionsExport->run();
	    	}
	    	// Rosters
	    	$rostersSync = new RostersSync();
	    	if($rostersSync->run()) {
	    		$rostersExport = new RostersExport();
	    		$rostersExport->run();
	    	}
    	}
    }
}
