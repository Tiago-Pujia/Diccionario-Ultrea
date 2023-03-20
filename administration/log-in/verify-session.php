<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/API/admin/verify-session.php';

if($verifySession){
    include_once 'session.php';
}

setcookie('session','ak92nd9',time()+86400*30,'/');

?>