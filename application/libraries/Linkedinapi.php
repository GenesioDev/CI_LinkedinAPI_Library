<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter LinkedinAPI
 *
 * A CodeIgniter library to interact with Redis
 *
 * @package        	CodeIgniter
 * @category    	Libraries
 * @author        	Benjamin Envent - Genesio
 * @version		v0.1
 */
class Linkedinapi {

    /**
     * CI
     *
     * CodeIgniter instance
     * @var 	object
     */
    private $_ci;

    /**
     * Client ID
     *
     * @var 	string
     */
    private $_clientId;

    /**
     * Client Secret
     *
     * Secret key for LinkedIn API
     * @var		string
     */
    private $_secretClient;

    /**
     * Redirect URI
     *
     * URI to redirect to after linkedin connection
     * @var		string
     */
    private $_redirectUri;

    /**
     * Authorization URL
     *
     * Linkedin Authorization URL
     * @var		string
     */
    private $_authorizationUrl;

    /**
     * Access Token URL
     *
     * Linkedin Access Token URL
     * @var		string
     */
    private $_accessTokenUrl;

    /**
     * Profile URL
     *
     * Linkedin Profile URL
     * @var		string
     */
    private $_profileUrl;

    /**
     * Profile Fields
     *
     * List Profile Fields
     * @var		array
     */
    private $_profileFields;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Load Config File
        $this->_ci = get_instance();
        $this->_ci->load->config('linkedin');

        $this->_clientId         = $this->_ci->config->item('linkedin_clientId');
        $this->_clientSecret     = $this->_ci->config->item('linkedin_clientSecret');
        $this->_redirectUri      = $this->_ci->config->item('linkedin_redirectUri');
        $this->_authorizationUrl = $this->_ci->config->item('linkedin_authorizationUrl');
        $this->_accessTokenUrl   = $this->_ci->config->item('linkedin_accessTokenUrl');
        $this->_profileUrl       = $this->_ci->config->item('linkedin_profileUrl');
        $this->_profileFields    = $this->_ci->config->item('linkedin_profileFields');
    }

    /**
     * Get link to connect with
     */
    public function getConnectLink($state) {
        $url = $this->_authorizationUrl . '?response_type=code&client_id=' . $this->_clientId . '&redirect_uri=' .
            urlencode($this->_redirectUri) . '&state=' . $state . '&scope=r_basicprofile%20r_emailaddress';

        return $url;
    }

    /**
     * Get token
     */
    public function getToken($code) {
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $this->_accessTokenUrl);
        curl_setopt($c, CURLOPT_HTTPHEADER,
            array(
                'Host: www.linkedin.com',
                'Content-Type: application/x-www-form-urlencoded'
            )
        );
        curl_setopt($c,	CURLOPT_POST, TRUE);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($c, CURLOPT_POSTFIELDS, 'grant_type=authorization_code&code=' . $code . '&redirect_uri=' . urlencode($this->_redirectUri) . '&client_id=' . $this->_clientId . '&client_secret=' . $this->_clientSecret);

        $result = json_decode(curl_exec($c));

        curl_close($c);

        if(property_exists($result, 'error')) {
            throw new ErrorException($result->error_description);
        }

        return $result->access_token;
    }

    /**
     * Get profile
     */
    public function getProfile($token, $aFields = array()) {
        if(count($aFields) == 0) {
            $aFields = $this->_profileFields;
        }

        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $this->_profileUrl . ':(' . implode(',', $aFields) . ')?format=json');
        curl_setopt($c, CURLOPT_HTTPHEADER,
            array(
                'Host: www.linkedin.com',
                'Authorization: Bearer ' . $token
            )
        );
        curl_setopt($c, CURLOPT_RETURNTRANSFER, TRUE);

        $result = json_decode(curl_exec($c));

        curl_close($c);

        if(property_exists($result, 'errorCode')) {
            throw new ErrorException($result->message);
        }

        return $result;
    }

}
