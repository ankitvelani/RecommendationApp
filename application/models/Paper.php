<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author ankit
 */
class Paper extends CI_Model{
    //put your code here
    public function __construct() {
        parent::__construct();
        
    }
    
    public function getPaper($paperID)
    {
        $this->db->select(' title ');
        $this->db->from('paper');
        $this->db->where('ID',$paperID);
        $this->db->limit(1);
        
        $qry=  $this->db->get();
        if($qry->num_rows()==1)
        {
            return $qry->result();
        }
        else
        {
            return FALSE;
        }
    }
}
