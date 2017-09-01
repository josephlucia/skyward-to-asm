<?php

namespace App\Skyward\Sections;

use App\Section;
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

            Section::truncate();

            foreach($locations as $location) {
                
                $sections = collect($this->skyward->getData('/v1/schools/'.$location->location_id.'/sections?schoolYear='.$schoolYear.'&limit=10000'))
                                ->where('SectionStatus', 'active');

                if($sections->count() >= 1) {
                    foreach($sections as $section) {
                        Section::create([
                            'class_id' => $section->SectionId,
                            'class_number' => $section->SectionId,
                            'course_id' => $section->CourseId,
                            'instructor_id' => NULL,
                            'instructor_id_2' => NULL,
                            'instructor_id_3' => NULL,
                            'location_id' => $section->SchoolId
                        ]);
                    }
                }
            }
        }
        // Update the instructor based on the staff sections table.
        $sections = Section::all();

        if(count($sections)) {
            foreach($sections as $section) {
                $staffSections = StaffSection::where('section', $section->class_id)->get();

                if($staffSections->count() == 1) {
                    $section->update([
                        'instructor_id' => $staffSections[0]->person_id
                    ]);
                }
                if($staffSections->count() == 2) {
                    $section->update([
                        'instructor_id' => $staffSections[0]->person_id,
                        'instructor_id_2' => $staffSections[1]->person_id
                    ]);
                }
                if($staffSections->count() == 3) {
                    $section->update([
                        'instructor_id' => $staffSections[0]->person_id,
                        'instructor_id_2' => $staffSections[1]->person_id,
                        'instructor_id_3' => $staffSections[2]->person_id
                    ]);
                }
            }
        }

        return true;
    }
}