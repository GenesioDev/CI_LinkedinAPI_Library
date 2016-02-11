# CodeIgniter Linkedin API Library
====

## Installation
- Copy files in your CodeIgniter folder

## Configuration
In the config file replace :
- YOUR_CLIENT_ID by the client id in your linkedin developper account
- YOUR_CLIENT_SECRET by the client secret in your linkedin developper account
- YOUR_REDIRECT_URI by the redirect uri you add on your linkedin developper account

    $config['linkedin_clientId']            = 'YOUR_CLIENT_ID';
    $config['linkedin_clientSecret']        = 'YOUR_CLIENT_SECRET';
    $config['linkedin_redirectUri']         = 'YOUR_REDIRECT_URI';

## Load
Add it on the autoload config file or load it in your controller :

    $this->load->library('linkedinapi');

## Usage

### Get the link to connect with Linkedin

    $this->linkedinapi->getConnectLink('bgtfsdqs');


### Get the authorization token

    $this->linkedinapi->getToken($codeReturnByLinkedin);


### Get profile information

    $this->linkedinapi->getProfile($tokenFromLinkedin);
