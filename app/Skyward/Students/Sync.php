<?php

namespace App\Skyward\Students;

use App\Student;
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
        $locations = Location::where('sync', true)->orderBy('location_id')->get();

        if($locations->count() >= 1) {

            Student::truncate();

            foreach($locations as $location) {
                
                $students = collect($this->skyward->getData('/v1/schools/'.$location->location_id.'/students?limit=10000'));

                if($students->count() >= 1) {

                    foreach($students as $student) {
                        Student::create([
                            'person_id' => $student->NameId,
                            'person_number' => $student->DisplayId,
                            'first_name' => $student->FirstName,
                            'middle_name' => $student->MiddleName,
                            'last_name' => $student->LastName,
                            'grade_level' => $this->skyward->getGrade($student->GradYr),
                            'email_address' => $student->SchoolEmail,
                            'sis_username' => $student->Username,
                            'password_policy' => null,
                            'location_id' => $student->DefaultSchoolId
                        ]);
                    }
                }
            }
        }

        return true;
    }
}