<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Config for the CodeIgniter LinkedinAPI library
 *
 * @see ../libraries/LinkedinAPI.php
 */

$config['linkedin_clientId']            = 'YOUR_CLIENT_ID';
$config['linkedin_clientSecret']        = 'YOUR_CLIENT_SECRET';
$config['linkedin_redirectUri']         = 'YOUR_REDIRECT_URI';
$config['linkedin_authorizationUrl']    = 'https://www.linkedin.com/uas/oauth2/authorization';
$config['linkedin_accessTokenUrl']      = 'https://www.linkedin.com/uas/oauth2/accessToken';
$config['linkedin_profileUrl']          = 'https://api.linkedin.com/v1/people/~';
$config['linkedin_profileFields']       = array(
    'id',
    'first-name',
    'last-name',
    'maiden-name',
    'formatted-name',
    'phonetic-first-name',
    'phonetic-last-name',
    'formatted-phonetic-name',
    'headline',
    'location',
    'industry',
    'current-share',
    'num-connections',
    'num-connections-capped',
    'summary',
    'specialties',
    'positions',
    'picture-url',
    'site-standard-profile-request',
    'api-standard-profile-request',
    'public-profile-url',
    'email-address',
);
