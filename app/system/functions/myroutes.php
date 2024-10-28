<?php

include_once "app/system/extras/Routes.php";
new Routes($routes);
include "access/routes/_default.php";
include "access/routes/custom_routes.php";


?>