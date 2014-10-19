<?php
/**
 * Created by PhpStorm.
 * User: Niesmo
 * Date: 10/18/14
 * Time: 8:59 PM
 */

class User implements JsonSerializable{
    private $user_id;
    private $fname;
    private $lname;
    private $username;
    private $password;
    private $email;
    private $phone_number;
    private $creation_date;

    public function __construct($data = NULL){
        if(is_numeric($data)){
            $this->get_user_by_id((int)$data);
        }
        else if(is_array($data)&&isset($data)){
            $this->set_array($data);
        }
        else{
            $this->set_object($data);
        }
    }

    public function get_id(){
        return $this->user_id;
    }

    public function get_name(){
        return $this->fname . " " . $this->lname;
    }

    public function get_username(){
        return $this->username;
    }

    public function get_password(){
        return $this->password;
    }

    public function get_email(){
        return $this->email;
    }

    public function get_phone_number(){
        return $this->phone_number;
    }

    public function get_creation_date(){
        return $this->creation_date;
    }


    public function jsonSerialize(){
        //dont have time to do this now
        return [

        ];
    }

    private function get_user_by_id($id){
        global $db;
        $database = $db;

        $temp = $database->select("user", "*", "user_id = {$id}");
        $this->set_array($temp[0]);

        return $this;
    }

    private function set_array($arr){
        if(isset($arr['user_id'])) $this->user_id = $arr['user_id'];
        if(isset($arr['fname'])) $this->fname = $arr['fname'];
        if(isset($arr['lname'])) $this->lname= $arr['lname'];
        if(isset($arr['username'])) $this->username = $arr['username'];
        if(isset($arr['email'])) $this->email = $arr['email'];
        if(isset($arr['password'])) $this->password = $arr['password'];
        if(isset($arr['phone_number'])) $this->phone_number = $arr['phone_number'];
        if(isset($arr['creation_date'])) $this->creation_date = $arr['creation_date'];

        return $this;
    }

    private function set_object($obj){
        return NULL;
    }

}