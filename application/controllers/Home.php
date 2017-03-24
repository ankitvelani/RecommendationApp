<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Home
 *
 * @author ankit
 */
class Home extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('paper','',TRUE);
    }

   
          function index() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $id=$session_data['id'];
           
            exec("Rscript ./R/RatingBasedRecommendation.R $id ",$res);
            $res=substr($res[0], 1, (strlen($res[0])-2));
            $paperIDs=  explode(",", $res);
            
            $paperDetail=array();
            foreach ($paperIDs as $id)
            {
                $paperID=substr($id, 1,(strlen($id)-2));
                 
                 $result=$this->paper->getPaper($paperID);
                
                $tempDetail=array(
                    "PaperID"=>$paperID,
                    "Title"=>$result[0]->title
                );
               array_push($paperDetail, $tempDetail);
                //$paperTitle[]=$result;
                 
            }
          
             $HeaderData['username']=$session_data['username'];
             $HeaderData['keywords']=$session_data['keywords'];
             $HeaderData['paperDetail']=$paperDetail;
            
             $this->load->view('templates/header',$HeaderData);
             $this->load->view('Page/home');
             $this->load->view('templates/footer');
             
            
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    function logout() {
        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect('home', 'refresh');
    }

}
