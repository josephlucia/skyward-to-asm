<?php

namespace App\Skyward\Staff;

use App\Staff;
use App\Skyward;
use App\Location;
use App\StaffSection;

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

            Staff::truncate();
            StaffSection::truncate();

            foreach($locations as $location) {
                
                $staff = collect($this->skyward->getData('/v1/schools/'.$location->location_id.'/staffmembers?limit=10000'))
                            ->where('PrimarySchoolId', $location->location_id)
                            ->where('IsTeacher', true);

                if($staff->count() >= 1) {
                    foreach($staff as $member) {
                        Staff::create([
                            'person_id' => $member->NameId,
                            'person_number' => $member->EmployeeId,
                            'first_name' => $member->FirstName,
                            'middle_name' => $member->MiddleName,
                            'last_name' => $member->LastName,
                            'email_address' => $member->Email,
                            'sis_username' => $member->Username,
                            'location_id' => $member->PrimarySchoolId
                        ]);
                    }
                }

                $sections = collect($this->skyward->getData('/v1/schools/'.$location->location_id.'/staffmembers/enrollments?schoolYear='.$schoolYear.'&limit=10000'));

                if($sections->count() >= 1) {
                    foreach($sections as $section) {
                        StaffSection::create([
                            'section' => $section->SectionId,
                            'person_id' => $section->NameId
                        ]);
                    }
                }
            }
        }

        return true;
    }
}