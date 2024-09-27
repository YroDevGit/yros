<?php


Routes::set_default_route("main/welcome_page"); // default route or main page

Routes::add("page_not_found", "main/page_not_found");
Routes::add("error", "main/error_page");

//You can add more routes below:: 
//SET template::  Routes::set(["" => ""]);
//ADD template::  Routes::add("", "");





?>