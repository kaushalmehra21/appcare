<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ApiController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(["url", "valid"]);
        $this->load->library(['session']);

        $this->load->model([
            'UsersModel'
        ]);
    }

    public function init()
    {
        $_REQUEST = $this->request();
        $method_name = $_REQUEST['method_name'];
        $this->$method_name();
    }



    public function getAllUsers()
    {

        $_REQUEST = $this->request();

        if (isset($_REQUEST['user_type'])) {
            $user_type  = strtoupper($_REQUEST['user_type']);
            $whr_arr  = ['conditions' => ['user_type' => $user_type]];
        } else {
            $whr_arr = null;
        }

        $query  = $this->UsersModel->all($whr_arr);
        //echo $this->db->last_query();
        if ($query) {
            $this->response($query, "All Users");
        } else {
            $this->response($query, "No data");
        }
    }

    public function getSingleUser()
    {

        $_REQUEST = $this->request();

        if (isset($_REQUEST['user_id'])) {
            $whr_arr  = ['conditions' => ['id' => $_REQUEST['user_id']]];
        }

        $query  = $this->UsersModel->first($whr_arr);

        if ($query) {
            $this->response($query, "Sigle Users");
        } else {
            $this->response($query, "No data");
        }
    }


    public function registerUser()
    {

        $_REQUEST       = $this->request();
        $first_name     = $_REQUEST['first_name'];
        $email          = $_REQUEST['email'];
        $mobile         = $_REQUEST['mobile'];
        $pass           = $_REQUEST['password'];
        $already        = '';

        $hash_pass      = hash_hmac('sha1', $pass, PASSWORD_SALT);

        if (isset($email) && !empty($email)) {

            $query  = $this->UsersModel->first(['email' => $email]);

            if ($query) {

                $this->response($query = null, "email already exist");
            } else {
                if (isset($mobile) && !empty($mobile)) {
                    $query  = $this->UsersModel->first(['mobile' => $mobile]);
                    if ($query) {
                        $this->response($query = null, "mobile already exist");
                    } else {

                        $arr = [
                            'first_name'        => $first_name,
                            'email'             => $email,
                            'username'          => $first_name,
                            'mobile'            => $mobile,
                            'password'          => $hash_pass
                        ];

                        if (isset($_REQUEST['user_type'])) {
                            $user_type  = strtoupper($_REQUEST['user_type']);
                            $arr['user_type']  = strtoupper($user_type);
                        } else {
                            $arr['user_type']  = 'STUDENT';
                        }

                        $user_id        = $this->UsersModel->save($arr);
                        echo $this->db->last_query();
                        $user           = $this->UsersModel->first($user_id);
                        $otp            = rand(1000, 9999);
                        $user['otp']    = $otp;

                        if ($user) {
                            //$msg  = "Hi " . $user['first_name'] . ", Thank you for registration, your OTP is " . $otp . ". Please do not share it to anyone.";
                            //$this->shootMsg($msg, $mobile);
                            $this->response($user, "Registration successful");
                        } else {
                            $this->response($user, "Not Registered");
                        }
                    }
                }
            }
        }
    }


    // Function to get the client IP address
    public function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function response($data, $message = false)
    {
        $fff = new stdClass();
        $fff->response = new stdClass();
        //$fff-&gt;response-&gt;message = false;
        $fff->response->message = $message;

        if (!empty($data)) {
            $fff->response->status = "success";
        } else {
            $fff->response->status = "unsuccess";
        }

        $fff->response->data  = $data;

        echo json_encode($fff);
    }

    public function request()
    {

        $json = file_get_contents('php://input', true);
        $data_ = json_decode($json);

        foreach ($data_ as $key => $value) {
            $data[$key] = $value;
        }

        return $data;
    }
}
