<?php

namespace App\Skyward\Locations;

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
        $schools = collect($this->skyward->getData('/v1/schools'));

        if($schools->count() >= 1) {
            foreach($schools as $school) {
                Location::updateOrCreate(
                    ['location_id' => $school->SchoolId],
                    [
                        'location_id' => $school->SchoolId,
                        'location_name' => $school->SchoolName
                    ]
                );
            }
        }
        
        return true;
    }
}