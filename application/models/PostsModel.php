<?php defined('BASEPATH') or exit('No direct script access allowed');

class PostsModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->database();
        $this->tableName = 'posts';
    }
}

/* End of file PostsModel.php */
