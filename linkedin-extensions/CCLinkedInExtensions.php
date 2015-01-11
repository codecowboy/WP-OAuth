<?php
/**
 * Created by PhpStorm.
 * User: lukemackenzie
 * Date: 01/01/2015
 * Time: 09:43
 */

namespace CC\LinkedIn;

use \League\OAuth2\Client\Provider as league;
use \League\OAuth2\Client\Token\AccessToken;
use \League\OAuth2\Client\Entity\User;

class CCLinkedInExtensions extends league\LinkedIn {

    public $scopes = ['r_fullprofile r_emailaddress r_contactinfo'];
    public $fields = [
        'id', 'email-address', 'first-name', 'last-name', 'headline',
        'location', 'industry', 'picture-url', 'public-profile-url',
        'skills', 'recommendations-received', 'three-current-positions',
        'three-past-positions'
    ];

    public function userDetails($response, AccessToken $token)
    {
        $user = new User();
        $email = (isset($response->emailAddress)) ? $response->emailAddress : null;
        $location = (isset($response->location->name)) ? $response->location->name : null;
        $description = (isset($response->headline)) ? $response->headline : null;
        $pictureUrl = (isset($response->pictureUrl)) ? $response->pictureUrl : null;
        $skills = (isset($response->skills)) ? $response->skills : null;
        $recommendations = (isset($response->recommendationsReceived)) ? $response->recommendationsReceived : null;
        $currentPositions = (isset($response->threeCurrentPositions)) ? $response->threeCurrentPositions : null;
        $pastPositions = (isset($response->threePastPositions)) ? $response->threePastPositions : null;

        //used by league\user
        $user->exchangeArray([
                                 'uid' => $response->id,
                                 'name' => $response->firstName.' '.$response->lastName,
                                 'firstname' => $response->firstName,
                                 'lastname' => $response->lastName,
                                 'email' => $email,
                                 'location' => $location,
                                 'description' => $description,
                                 'imageurl' => $pictureUrl,
                                 'urls' => $response->publicProfileUrl,

                             ]);

        return array('user'=>$user,
                     'skills' => $skills,
                     'recommendations' => $recommendations,
                     'currentpositions' => $currentPositions,
                     'pastpositions' => $pastPositions,
            );

    }



}