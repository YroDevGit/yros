<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Student extends Yros{

        public function __construct() {
            parent::__construct();
            $YROS = &Yros::get_instance();
        }

        public function index(){
            echo 'Hello Yros user.';
        }

        public function showPage(){
            view_page("student");
        }

        public function addStudent(){
            $this->validationlib->validate_input("fullname", "Fullname", "required");
            if($this->validationlib->validation_failed()){
                echo $this->validationlib->get_input_error("fullname");
            }
            $fullname = input("fullname");
            $course = input("course");
            
            $data = [
                "name" => $fullname,
                "course" => $course
            ];

            $result = db_insert("student", $data);
            print_r($result);

        }


    
        

        
       

        
    }
?>