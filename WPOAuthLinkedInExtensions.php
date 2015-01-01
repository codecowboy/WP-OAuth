<?php
/**
 * Created by PhpStorm.
 * User: lukemackenzie
 * Date: 01/01/2015
 * Time: 09:43
 */

namespace WPOAuth\LinkedIn;

use \League\OAuth2\Client\Provider;

class WPOAuthLinkedInExtensions extends Provider\LinkedIn {

    function getPersonSkills() {

        return 'yay';



    }


}