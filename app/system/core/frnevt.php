<?php

function view(string $view, array $data = array()){
    if(! empty($data)){
        extract($data);
    }
    include_once "views/".$view.".php";
}

 function view_content(string $view, array $data = array()){
    view("contents/".$view, $data);
}

 function view_include(string $view, array $data = array()){
    view("includes/".$view, $data);
}

 function view_error(string $view, array $data = array()){
    view("errors/".$view, $data);
}

 function view_page(string $view, array $data = array()){
    view("pages/".$view, $data);
}

 function view_partial(string $view, array $data = array()){
    view("partials/".$view, $data);
}

?>