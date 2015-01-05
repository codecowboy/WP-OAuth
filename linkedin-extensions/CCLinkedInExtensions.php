<?php
/**
 * Created by PhpStorm.
 * User: lukemackenzie
 * Date: 01/01/2015
 * Time: 09:43
 */

namespace CC\LinkedIn;

use \League\OAuth2\Client\Provider as league;

class CCLinkedInExtensions extends league\LinkedIn {

    function getPersonSkills() {

        error_log('yay');
        return 'yay';



    }


}