<?php defined('BASEPATH') or exit('No direct script access allowed');

class DailyAttandenceModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->database();
        $this->tableName = 'daily_attandance';
    }
}

/* End of file CareersModel.php */
