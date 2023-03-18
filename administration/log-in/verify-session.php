<?php
if(!isset($_COOKIE['session']) || $_COOKIE['session'] != 'ak92nd9'){
    include_once 'session.php';
}

setcookie('session','ak92nd9',time()+86400*30,'/');
?>