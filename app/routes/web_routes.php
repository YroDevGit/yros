<?php
//Main routes.
Routes::set_default_route("main/welcome_page"); // default route or main page

Routes::set_PageNotFound_route("main/page_not_found"); //Page not found route

Routes::set_PageError_route("main/error_page");

//Custom routes below:
/**Rules:
 * param 1: route name
 * param 2: controller's path
 */
//SET template::==>   Routes::set(["" => ""]);
//ADD template::==>   Routes::add("", "");

Routes::set(["sample" => "main/sample_page"]); //This is a sample route, you can add below










?>