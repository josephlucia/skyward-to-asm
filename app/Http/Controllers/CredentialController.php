<?php

namespace App\Http\Controllers;

use App\Skyward;
use App\Credential;
use App\Skyward\Locations\Sync;
use Illuminate\Http\Request;

class CredentialController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Fetch the credentials.
     *
     * @return object
     */
    public function fetch()
    {
        $credentials = Credential::where('id', 1)->first();

        return $credentials;
    }

    /**
     * Store the credentials in the database and test.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request.
        $this->validate($request, [
            'domain' => 'required',
            'consumer_secret' => 'required',
            'consumer_key' => 'required'
        ]);
        // Store the credentials in the database.
        $credentials = Credential::updateOrCreate(
        	['id' => 1],
        	[
        		'id' => 1,
        		'domain' => $request->domain,
        		'consumer_secret' => $request->consumer_secret,
        		'consumer_key' => $request->consumer_key
        	]
        );
        // Test the credentials.
        $skyward = new Skyward(true);

        $token = $skyward->validateCredentials();

        if(isset($token->access_token)) {
            // Populate the locations table.
            $sync = new Sync();
            $sync->run();
            
        	return back()->with('success', 'The API credentials are valid. The Locations have been populated.');

        } else {
            $credentials->update([
                'valid' => false,
                'sync' => false
            ]);

        	return back()->with('error', 'The API credentials are not valid, please try again.');

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($status)
    {
        $credentials = Credential::findOrFail(1);

        $credentials->update([
            'sync' => $status
        ]);
    }
}
