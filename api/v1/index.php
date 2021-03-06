<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require('Autoload.php');
require('class.RegisterAPI.php');
require('class.VariablesAPI.php');
require('class.RegistrationAPI.php');

$site = new \Http\WebSite();
$site->registerAPI('/', new RegisterAPI());
$site->registerAPI('/vars', new VariablesAPI());
$site->registerAPI('/art', new RegistrationAPI('art', 'ArtAdmins'));
$site->registerAPI('/camps', new RegistrationAPI('camps', 'CampAdmins'));
$site->registerAPI('/dmv', new RegistrationAPI('dmv', 'DMVAdmins'));
$site->registerAPI('/event', new RegistrationAPI('event', 'EventAdmins'));
$site->run();
/* vim: set tabstop=4 shiftwidth=4 expandtab: */
