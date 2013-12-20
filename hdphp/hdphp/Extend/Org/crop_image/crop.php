<?php
//if (!defined("HDPHP_PATH"))
//    exit('No direct script access allowed');
$path = dirname(__FILE__);
$url = str_replace("/www","http://localhost",$path);
$action = isset($_GET['action']) ? $_GET['action'] : "show";
switch ($action) {
    case "show":
        require $path . '/tpl/show.php';
        break;
}

