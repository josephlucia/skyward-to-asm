<?php

namespace App\Skyward\Courses;

use App\Course;
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

            Course::truncate();

            foreach($locations as $location) {
                
                $courses = collect($this->skyward->getData('/v1/schools/'.$location->location_id.'/courses?schoolYear='.$schoolYear.'&limit=10000'))
                                ->where('CourseStatus', 'active');

                if($courses->count() >= 1) {

                    foreach($courses as $course) {
                        Course::create([
                            'course_id' => $course->CourseId,
                            'course_number' => $course->CourseKey,
                            'course_name' => $course->CourseLongDesc,
                            'location_id' => $course->SchoolId
                        ]);
                    }
                }
            }
        }

        return true;
    }
}