<?php
// Start Session
session_start();

// Include Config
require('config.php');

require('classes/Messages.php');
require('classes/View.php');
require('classes/Controller.php');
require('classes/Model.php');

require('controllers/home.php');
require('controllers/shares.php');
require('controllers/users.php');

require('models/home.php');
require('models/share.php');
require('models/user.php');

$view = new View($_GET);
$controller = $view->createController();
if($controller){
	$controller->executeAction();
}