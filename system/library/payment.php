<?php
/**
 * @package		eComm365
 * @author		Luca Di Bello
 * @copyright	Copyright (c) 2019, DuxBack, Ltd. (https://www.duxback.ie/)
 * @license		https://opensource.org/licenses/GPL-3.0
 * @link		https://www.duxback.ie
 */

class Payment
{
    /**
     * @var string Username for API auth
     */
    private $Username = "";

    /**
     * @var string Password for API auth
     */
    private $Password = "";

    /**
     * @var string Vendor Id for API auth
     */
    private $VendorID = "";

    /**
     * Payment constructor method.
     * @param String $username Username for API auth.
     * @param String $password Password for API auth.
     * @param String $vendor_id Vendor Id for API auth.
     */
    function __construct(String $username,String $password,String $vendor_id)
    {
        $this->Username = $username;
        $this->Password = $password;
        $this->VendorID = $vendor_id;

        define("DEFAULT_API_URL", "https://staging.ecomm365.com/acqapi/service.ashx");
    }

    /**
     * This function is used to send a POST request to a specific website.
     * @param $url String Website where the request will be send.
     * @param $params array All the data that will be send to the website.
     * @return mixed Website response
     */
    public function httpPost($params, String $url = DEFAULT_API_URL)
    {
        $params = http_build_query($params); //Define Parms

        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec( $ch );
        curl_close($ch);

        return $response;
    }

    /**
     * This function is used to generate a unique 128bit GUID for identifying payments.
     * @return string Unique 128bit long GUID String.
     */
    public function GUID()
    {
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    /**
     * Getter method for username attribute.
     * @return string Username used for API auth.
     */
    public function getUsername(): string
    {
        return $this->Username;
    }

    /**
     * Getter method for password attribute.
     * @return string Password used for API auth.
     */
    public function getPassword(): string
    {
        return $this->Password;
    }

    /**
     * Getter method for vendor id attribute.
     * @return string Vendor id used for API auth.
     */
    public function getVendorID(): string
    {
        return $this->VendorID;
    }
}