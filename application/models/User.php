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
class User extends CI_Model{
    //put your code here
    public function __construct() {
        parent::__construct();
        
    }
    
    public function login($username,$password)
    {
        $this->db->select(' id , username , password ,keywords ');
        $this->db->from('user');
        $this->db->where('Username',$username);
        $this->db->where('Password',$password);
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
