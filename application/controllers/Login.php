<?php


defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 *
 * @author ankit
 */
class Login extends CI_Controller {
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
      
    }
    function index()
    {
        
          if ($this->session->userdata('logged_in')) {
               $session_data = $this->session->userdata('logged_in');
               
            $HeaderData['username']=$session_data['username'];
            
            

            
             $this->load->view('templates/header',$HeaderData);
             $this->load->view('Page/home');
             $this->load->view('templates/footer');
          }
        else {
             $this->load->helper(array('form')); 
             
             $this->load->view('templates/header');
             $this->load->view('login_view');
             $this->load->view('templates/footer');
        }
       
    }
}
