<?php 
if ($GLOBALS['ROUTE_1'] == 'news') {
    switch($GLOBALS['ROUTE_2']) {
        case 'create':
            include('views/pages/news_create.php');
            break;
        case 'update':
            include('views/pages/news_update.php');
            break;
        case 'remove':
            include('views/pages/news_remove.php');
            break;
        default:
            include('views/pages/news.php');
            break;
    }
}
else {
    include('views/pages/home.php');
}