<?php

include_once 'verify-session.php';

if($verifySessionAdmin){
    include_once 'login.php';
}

setcookie('session','ak92nd9',time()+86400*30,'/');

?>