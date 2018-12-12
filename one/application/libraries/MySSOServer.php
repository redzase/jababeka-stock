<?php

use Jasny\ValidationResult;
use third_party\sso;

/**
 * Example SSO server.
 * 
 * Normally you'd fetch the broker info and user info from a database, rather then declaring them in the code.
 */
class MySSOServer extends SSO\Server
{
    /**
     * Registered brokers
     * @var array
     */
    private static $brokers = [
        'stock' => ['secret'=>'C6wkZ29gBXQ2Xb0FYEbWHw'],
    ];

    // /**
    //  * System users
    //  * @var array
    //  */
    // private static $users = array (
    //     'jackie' => [
    //         'fullname' => 'Jackie Black',
    //         'email' => 'jackie.black@example.com',
    //         'password' => '$2y$10$lVUeiphXLAm4pz6l7lF9i.6IelAqRxV4gCBu8GBGhCpaRb6o0qzUO' // jackie123
    //     ],
    //     'john' => [
    //         'fullname' => 'John Doe',
    //         'email' => 'john.doe@example.com',
    //         'password' => '$2y$10$RU85KDMhbh8pDhpvzL6C5.kD3qWpzXARZBzJ5oJ2mFoW7Ren.apC2' // john123
    //     ],
    // );

    private $CI = NULL;

    public function __construct() {
        parent::__construct();

        $this->CI = & get_instance();

        $this->CI->load->model('Authmodel');
    }

    /**
     * Get the API secret of a broker and other info
     *
     * @param string $brokerId
     * @return array
     */
    protected function getBrokerInfo($brokerId)
    {
        return isset(self::$brokers[$brokerId]) ? self::$brokers[$brokerId] : null;
    }

    /**
     * Authenticate using user credentials
     *
     * @param string $username
     * @param string $password
     * @return ValidationResult
     */
    protected function authenticate($username, $password)
    {
        // if (!isset($username)) {
        //     return ValidationResult::error("username isn't set");
        // }
        
        // if (!isset($password)) {
        //     return ValidationResult::error("password isn't set");
        // } 
        
        // if (!isset(self::$users[$username]) || !password_verify($password, self::$users[$username]['password'])) {
        //     return ValidationResult::error("Invalid credentials");
        // }

        return ValidationResult::success();
    }


    /**
     * Get the user information
     *
     * @return array
     */
    protected function getUserInfo($username)
    {
        // if (!$this->CI->session->userdata(PREFIX_SESSION . "_USER_ID")) return null;
    
        // $ses_user_data = array(
        //     "user_id"    => $this->CI->session->userdata(PREFIX_SESSION . "_USER_ID"),
        //     "username"   => $this->CI->session->userdata(PREFIX_SESSION . "_USER_USERNAME"),
        //     "all_access" => $this->CI->session->userdata(PREFIX_SESSION . "_ALL_ACCESS"),
        // );

        $params = array(
            "email" => $username,
            );
        $all_data = $this->CI->Authmodel->check_email($params);

        $ses_user_data = [];
        if ($all_data) {
            $ses_user_data = array(
                PREFIX_SESSION . "_USER_ID"       => $all_data->id,
                PREFIX_SESSION . "_USER_USERNAME" => $all_data->username,
                PREFIX_SESSION . "_ALL_ACCESS"    => $all_data->all_access,
                PREFIX_SESSION . "_MENU"          => $all_data->menu,
            );
        } 

        return $ses_user_data;
    }
}
