<?php

namespace App\Skyward\Rosters;

use App\Roster;
use App\Skyward;
use App\Location;

class Sync
{
    /**
     * The skyward class that contains the helper functions.
     * @var mixed
     */
	private $skyward;

    /**
     * Create a new Skyward instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->skyward = new Skyward();
    }

    /**
     * Consume the Skyward API and fill the locations table.
     *
     * @return void 
     */
    public function run()
    {
        $schoolYear = $this->skyward->getCurrentSchoolYear();

        $locations = Location::where('sync', true)->orderBy('location_id')->get();

        if($locations->count() >= 1) {

            Roster::truncate();

            foreach($locations as $location) {
                
                $rosters = collect($this->skyward->getData('/v1/schools/'.$location->location_id.'/students/enrollments?schoolYear='.$schoolYear.'&limit=10000'))
                                ->where('EnrStatus', 'active');

                if($rosters->count() >= 1) {

                    foreach($rosters as $roster) {
                        Roster::create([
                            'roster_id' => $roster->EnrollmentId,
                            'class_id' => $roster->SectionId,
                            'student_id' => $roster->NameId
                        ]);
                    }
                }
            }
        }

        return true;
    }
}