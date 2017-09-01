<?php

namespace App;

use App\Log;
use App\Oauth;
use Carbon\Carbon;
use App\Credential;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Skyward
{
    /**
     * The domain of the Skyward API.
     * @var string
     */
    private $domain;

    /**
     * Initiate Skyward OAuth token request.
     *
     * @param boolean $reset 
     * @return void
     */
    public function __construct($reset = false)
    {
        $credentials = Credential::find(1);

        if(count($credentials)) {

            $this->domain = $credentials->domain;

            $token = Oauth::find(1);

            if(is_null($token) || isset($token) && $this->isExpired($token) || $reset == true) {

                $data = $this->validateCredentials();

                if(array_key_exists('access_token', $data)) {

                    $this->setAccessToken($data);

                } else {

                    return redirect('/home')->with('error', 'The API credentials are not valid, please try again.');

                }
            }
        }
    }

    /**
     * Validate the credentials of the Skyward API.
     * 
     * @return object
     */
    public function validateCredentials()
    {
        $credentials = Credential::find(1);

        if(count($credentials)) {
            
            $client = new Client();

            try {           
                $response = $client->request(
                'POST',
                $credentials->domain.'/api/token',
                [
                    'headers' => [
                        'Content-Type' => 'application/x-www-form-urlencoded'
                    ],
                    'form_params' => [
                        'username' => $credentials->consumer_secret,
                        'password' => $credentials->consumer_key,
                        'grant_type' => 'password'
                    ]
                ]
                );

                $data = json_decode($response->getBody());

                $credentials->update([
                    'valid' => true
                ]);

                return $data;

            } catch (GuzzleException $e) {

                $data = ['error' => $e->getMessage()];

                $credentials->update([
                    'valid' => false
                ]);

                return $data;

            }
        }
    }

    /**
     * Check if the token is expired after 1 hour.
     *
     * @param  object $token
     * @return boolean
     */
    private function isExpired($token)
    {
        return Carbon::now() > Carbon::parse($token->updated_at)->addHour() ? true : false;
    }

    /**
     * Set the access token in the database if none exists.
     *
     * @param  object $data
     * @return void
     */
    private function setAccessToken($data)
    {
        $token = Oauth::updateOrCreate(
            ['id' => 1],
            [
                'access_token' => $data->access_token,
                'token_type' => $data->token_type,
                'expires_in' => $data->expires_in
            ]
        );
    }

    /**
     * Get the access token from the database.
     *
     * @return string
     */
    public function getAccessToken()
    {
        $token = Oauth::find(1);

        return ucfirst($token->token_type) . ' ' . $token->access_token;
    }

    /**
     * Get the current school year based on date.
     *
     * @return date
     */
    public function getCurrentSchoolYear()
    {
        return date('m') >= '07' && date('m') <= '12' ? date('Y', strtotime('+1 years')) : date('Y');
    }

    /**
     * Get the current grade based on the grad year.
     *
     * @param integer $gradYear
     * @return string
     */
    public function getGrade($gradYear)
    {
        // Set the grade prefix.
        $prefix = (date('m') >= '07' && date('m') <= '12') ? 13 : 12;
        // Subtract the grade difference from the grade prefix.
        $grade = $prefix - ($gradYear - date('Y'));
        // Fix the grade for the students that didn't graduate on time.
        $grade = ($grade == 13) ? 12 : $grade;
        // Return the string K for kindergarten
        $grade = ($grade == 0) ? 'K' : $grade;

        return $grade;
    }

    /**
     * Consume the data from Skyward.
     *
     * @param string $api
     * @return array
     */
    public function getData($api)
    {
        $client = new Client();

        try {
            $response = $client->request(
                'GET',
                $this->domain.'/api' . $api,
                [
                    'headers' => [
                        'Authorization' => $this->getAccessToken()
                    ]
                ]
            );

            return json_decode($response->getBody());

        } catch (GuzzleException $e) {

            $log = Log::create([
                'source' => $api,
                'type' => 'sync error',
                'description' => $e->getMessage()
            ]);

            return $e->getMessage();

        }
    }
}
