<?php

session_start();

require 'class.user.php';

$session = new USER();

if(!$session->isLoggedIn()){

	$session->redirect('index.php');
}
