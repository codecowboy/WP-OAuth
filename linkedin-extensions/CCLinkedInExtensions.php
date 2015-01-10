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
        'location', 'industry', 'picture-url', 'public-profile-url', 'skills'
    ];

    public function getUserSkills(AccessToken $token)
    {

        return $this->fetchUserSkills($token);
    }

    protected function fetchUserSkills(AccessToken $token)
    {

        $url = $this->urlUserProfile($token);
        $response =  $this->fetchProviderData($url);
        return $this->userDetails(json_decode($response), $token);

    }

    public function urlUserProfile(AccessToken $token)
    {
        return 'https://api.linkedin.com/v1/people/~:('.implode(",", $this->fields)
        .')?format=json&oauth2_access_token='.$token;
    }

    public function userDetails($response, AccessToken $token)
    {
        $user = new User();
//d($response);
        $email = (isset($response->emailAddress)) ? $response->emailAddress : null;
        $location = (isset($response->location->name)) ? $response->location->name : null;
        $description = (isset($response->headline)) ? $response->headline : null;
        $pictureUrl = (isset($response->pictureUrl)) ? $response->pictureUrl : null;

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


        //todo format this better or combine into one object

        return array('user'=>$user, 'skills' => $response->skills);
    }



}