<?php
if(!isset($_GET['id_dictionary']) || !is_numeric($_GET['id_dictionary'])){
    header('Location: /select-dictionaries');
}