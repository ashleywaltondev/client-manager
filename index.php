<?php

//Set router variables
if ( isset($_GET['1']) && $_GET['1'] != '' ) {
    $GLOBALS['ROUTE_1'] = $_GET['1'];
}
if ( isset($_GET['2']) && $_GET['2'] != '' ) {
    $GLOBALS['ROUTE_2'] = $_GET['2'];
}

//Load base libraries
require('lib/database.php');
require('lib/functions.php');


include('views/header.php');
include('router.php');
include('views/footer.php');
