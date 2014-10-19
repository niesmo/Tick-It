<?php
/**
 * Created by PhpStorm.
 * User: Niesmo
 * Date: 10/18/14
 * Time: 6:51 PM
 */

class Ticket implements JsonSerializable{
    private $ticket_id;
    private $title;
    private $description;
    private $price;
    private $discounted_price;
    private $discount_start_time;
    private $discount_end_time;
    private $creation_date;
    private $created_by_id;
    private $created_at_id;
    private $email_shared;
    private $phone_number_shared;

    private $created_by_user;

    public function __construct($data=NULL){

        if(is_numeric($data)){
            $this->get_ticket_by_id((int)$data);
        }
        else if(is_array($data)&&isset($data)){
            $this->set_array($data);
        }
        else{
            $this->set_object($data);
        }
    }

    public function get_id(){
        return $this->ticket_id;
    }

    public function get_title(){
        return $this->title;
    }

    public function get_description($shotened = false, $length = 35){
        if($shotened){
            return $this->limitStrlen($this->description,$length);
        }
        return $this->description;
    }

    public function get_price(){
        return $this->price;
    }

    public function get_discounted_price(){
        return $this->discounted_price;
    }

    public function is_discounted(){
        if($this->discount_end_time == NULL) return false;
        $endOfDiscount = new DateTime($this->discount_end_time);
        $now = new DateTime();

        if($endOfDiscount < $now ) return false;
        return $this->price > $this->discounted_price;
    }

    public function get_discount_percentage(){
        return number_format(100 - ($this->discounted_price/$this->price*100),2);
    }

    public function get_discount_start_time(){
        return $this->discount_start_time;
    }

    public function get_discount_end_time(){
        return $this->discount_start_time;
    }

    public function get_discount_time_left(){
        $endOfDiscount = new DateTime($this->discount_end_time);
        $now = new DateTime();

        $diff = $endOfDiscount->diff($now);
        return $diff->format("%h:%i:%s");
    }

    public function get_creation_date(){
        return $this->creation_date;
    }

    public function get_created_by_id(){
        return $this->created_by_id;
    }

    public function get_created_at_id(){
        return $this->get_created_at_id;
    }

    public function is_email_sharable(){
        return $this->email_shared;
    }

    public function is_phone_number_sharable(){
        return $this->phone_number_shared;
    }

    public function get_created_by_user(){
        if(!isset( $this->created_by_user)){
            $this->created_by_user = new User($this->created_by_id);
            return $this->created_by_user;
        }
        return $this->created_by_user;
    }

    public function jsonSerialize ( ){
        return [
            "id"=>$this->ticket_id,
            "title"=>$this->title,
            "description"=>$this->description,
            "price"=>$this->price,
            "discounted_price"=>$this->discounted_price,
            "discount_start_time"=>$this->discount_start_time,
            "discount_end_time"=>$this->discount_end_time,
            "creation_date"=>$this->creation_date,
            "created_by_id"=>$this->created_by_id,
            "created_at_id"=>$this->created_at_id,
            "email_shared"=>$this->email_shared,
            "phone_number_shared"=>$this->phone_number_shared,
        ];
    }

    public function get_all_tickets(){
        global $db;
        $database = $db;

        $result = array();
        $tickets_arr = $database->select("ticket");

        foreach($tickets_arr as $t){
            $result[] = new Ticket($t);
        }
        return $result;
    }

    private function get_ticket_by_id($id){
        global $db;
        $database = $db;
        $this->set_array($database->select("ticket", "*", "ticket_id = {$id}"));
        return $this;
    }

    private function set_array($arr){
        if(isset($arr['ticket_id'])) $this->ticket_id = $arr['ticket_id'];
        if(isset($arr['title'])) $this->title = $arr['title'];
        if(isset($arr['description'])) $this->description = $arr['description'];
        if(isset($arr['price'])) $this->price = $arr['price'];
        if(isset($arr['discounted_price'])) $this->discounted_price = $arr['discounted_price'];
        if(isset($arr['discount_start_time'])) $this->discount_start_time = $arr['discount_start_time'];
        if(isset($arr['discount_end_time'])) $this->discount_end_time = $arr['discount_end_time'];
        if(isset($arr['creation_date'])) $this->creation_date = $arr['creation_date'];
        if(isset($arr['created_by_id'])) $this->created_by_id = $arr['created_by_id'];
        if(isset($arr['created_at_id'])) $this->created_at_id = $arr['created_at_id'];
        if(isset($arr['email_shared'])) $this->email_shared = $arr['email_shared'];
        if(isset($arr['phone_number_shared'])) $this->phone_number_shared = $arr['phone_number_shared'];

        return $this;
    }

    private function set_object($obj){
        return NULL;
    }


    private function limitStrlen($input, $length, $ellipses = true, $strip_html = true) {
        //strip tags, if desired
        if ($strip_html) {
            $input = strip_tags($input);
        }

        //no need to trim, already shorter than trim length
        if (strlen($input) <= $length) {
            return $input;
        }

        //find last space within length
        $last_space = strrpos(substr($input, 0, $length), ' ');
        if($last_space !== false) {
            $trimmed_text = substr($input, 0, $last_space);
        } else {
            $trimmed_text = substr($input, 0, $length);
        }
        //add ellipses (...)
        if ($ellipses) {
            $trimmed_text .= '...';
        }

        return $trimmed_text;
    }




} 